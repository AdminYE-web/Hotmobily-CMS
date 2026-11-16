<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductContentRevision;
use App\Models\ProductPage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ProductContentRevisionService
{
    public function saveDraft(Product $product, array $content): ProductPage
    {
        return DB::transaction(function () use ($product, $content) {
            $product = Product::query()->lockForUpdate()->findOrFail($product->id);
            $page = $product->page()->firstOrCreate();
            $this->baseline($product, $page);
            $page->update(['draft_content_json' => $content]);
            $this->record($product, 'draft_saved', $content);

            return $page;
        });
    }

    public function publish(Product $product, ?array $content = null): ProductPage
    {
        return DB::transaction(function () use ($product, $content) {
            $product = Product::query()->lockForUpdate()->findOrFail($product->id);
            $page = $product->page()->firstOrCreate();
            $this->baseline($product, $page);
            if ($content !== null) {
                $page->draft_content_json = $content;
            }
            $page->update(['published_content_json' => $page->draft_content_json, 'published_at' => now()]);
            $this->record($product, 'published', $page->draft_content_json, true);

            return $page;
        });
    }

    public function restore(Product $product, ProductContentRevision $revision, int $expectedVersion): ProductPage
    {
        return DB::transaction(function () use ($product, $revision, $expectedVersion) {
            $product = Product::query()->lockForUpdate()->findOrFail($product->id);
            abort_unless((int) $revision->product_id === (int) $product->id, 404);
            $version = (int) ProductContentRevision::where('product_id', $product->id)->max('version');
            if ($version !== $expectedVersion) {
                throw new ConflictHttpException('This product changed. Reload revision history and try again.');
            }
            $page = $product->page()->firstOrCreate();
            // Keep the current draft recoverable even if it was changed outside the editor.
            $this->record($product, 'before_restore', $page->draft_content_json ?? ['version' => 1, 'blocks' => []]);
            $content = $revision->snapshot_json['content'];
            $page->update(['draft_content_json' => $content]);
            $this->record($product, 'restored', $content, true, $revision->version);

            return $page;
        });
    }

    private function baseline(Product $product, ProductPage $page): void
    {
        if (ProductContentRevision::where('product_id', $product->id)->exists()) {
            return;
        }
        if (is_array($page->published_content_json)) {
            $this->record($product, 'initial_published', $page->published_content_json, true);
        }
        $this->record($product, 'initial_draft', $page->draft_content_json ?? ['version' => 1, 'blocks' => []]);
    }

    public function currentVersions(Product $product): array
    {
        $page = $product->page;
        $layout = $product->layout;
        $versions = [];
        foreach (['draft', 'published'] as $type) {
            $content = $page?->getAttribute($type.'_content_json');
            $layoutJson = $type === 'published'
                ? $layout?->published_layout_json
                : ($layout?->draft_layout_json ?? $layout?->published_layout_json);
            $revision = null;
            if (is_array($content)) {
                $hash = hash('sha256', json_encode(['content' => $content, 'layout' => $layoutJson], JSON_THROW_ON_ERROR));
                $query = ProductContentRevision::where('product_id', $product->id)->where('snapshot_hash', $hash);
                if ($type === 'published') {
                    $query->whereIn('action', ['published', 'initial_published']);
                }
                $revision = $query->orderByDesc('version')->first();
            }
            $versions[$type] = [
                'version' => $revision?->version,
                'restored_from_version' => $revision?->snapshot_json['restored_from_version'] ?? null,
                'has_content' => is_array($content),
            ];
        }

        return $versions;
    }

    private function record(Product $product, string $action, array $content, bool $forceAction = false, ?int $restoredFromVersion = null): void
    {
        $layout = $product->layout;
        $snapshot = [
            'content' => $content,
            'layout' => in_array($action, ['published', 'initial_published'], true)
                ? $layout?->published_layout_json
                : ($layout?->draft_layout_json ?? $layout?->published_layout_json),
        ];
        $hash = hash('sha256', json_encode($snapshot, JSON_THROW_ON_ERROR));
        if ($restoredFromVersion !== null) {
            $snapshot['restored_from_version'] = $restoredFromVersion;
        }
        $latest = ProductContentRevision::where('product_id', $product->id)->orderByDesc('version')->first();
        if ($latest && $latest->snapshot_hash === $hash && (! $forceAction || $latest->action === $action)) {
            return;
        }
        $actor = auth('admin')->user() ?? request()->user();
        ProductContentRevision::create([
            'product_id' => $product->id,
            'version' => ($latest?->version ?? 0) + 1,
            'action' => $action,
            'snapshot_json' => $snapshot,
            'snapshot_hash' => $hash,
            'created_by' => $actor?->staff_name ?: $actor?->email,
        ]);
    }
}
