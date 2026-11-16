<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Storefront\ProductController;
use App\Models\Product;
use App\Models\ProductContentRevision;
use App\Services\ProductContentRevisionService;
use Illuminate\Http\Request;

class ProductContentRevisionController extends Controller
{
    public function index(Product $product, ProductContentRevisionService $service)
    {
        return response()->json(['success' => true,
            'current_versions' => $service->currentVersions($product),
            'latest_version' => (int) ProductContentRevision::where('product_id', $product->id)->max('version'),
            'data' => ProductContentRevision::query()
            ->where('product_id', $product->id)->orderByDesc('version')
            ->paginate(20, ['id', 'version', 'action', 'created_by', 'created_at',
                'snapshot_json->restored_from_version as restored_from_version'])]);
    }

    public function restore(Request $request, Product $product, ProductContentRevision $revision, ProductContentRevisionService $service)
    {
        abort_unless((int) $revision->product_id === (int) $product->id, 404);
        $data = $request->validate(['expected_version' => ['required', 'integer', 'min:1']]);
        $service->restore($product, $revision, $data['expected_version']);

        return response()->json(['success' => true, 'message' => 'Revision restored to draft. Preview and publish when ready.']);
    }

    public function preview(Product $product, ProductContentRevision $revision)
    {
        abort_unless((int) $revision->product_id === (int) $product->id, 404);
        $snapshot = $revision->snapshot_json;
        abort_unless(is_array($snapshot['layout'] ?? null) && is_array($snapshot['content']['blocks'] ?? null), 422);
        $html = app(ProductController::class)->renderProduct(
            $product, true, $snapshot['content']['blocks'], $snapshot['layout'], false
        )->render();

        return response($html)->header('Cache-Control', 'no-store, private')->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
