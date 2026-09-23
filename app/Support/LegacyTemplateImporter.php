<?php

namespace App\Support;

use App\Models\TemplateProduct;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;

class LegacyTemplateImporter
{
    /** @return array{products: int, blocks: int, rows: int, downloads: int, skipped: int} */
    public function import(?string $sourcePath = null): array
    {
        $sourcePath ??= base_path('original-web/template/index.php');

        if (! File::isFile($sourcePath)) {
            throw new RuntimeException("Legacy template source was not found: {$sourcePath}");
        }

        $source = File::get($sourcePath);
        $document = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8">'.preg_replace('/<\?php.*?\?>/s', '', $source),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $xpath = new DOMXPath($document);
        $options = [];

        foreach ($xpath->query('//select[@id="prd_name"]/option[@value]') ?: [] as $option) {
            if (! $option instanceof DOMElement) {
                continue;
            }

            $value = trim($option->getAttribute('value'));
            if ($value === '') {
                continue;
            }

            $options[] = [
                'selector' => $value,
                'name' => $this->text($option),
            ];
        }

        $tablesByProduct = [];
        foreach ($xpath->query('//*[@id="result"]//table[@class]') ?: [] as $table) {
            if (! $table instanceof DOMElement) {
                continue;
            }

            $productName = trim($table->getAttribute('class'));
            if ($productName !== '') {
                $tablesByProduct[$productName][] = $table;
            }
        }

        $stats = [
            'products' => 0,
            'blocks' => 0,
            'rows' => 0,
            'downloads' => 0,
            'skipped' => 0,
        ];

        DB::transaction(function () use ($options, $tablesByProduct, $xpath, &$stats): void {
            foreach ($options as $productOrder => $option) {
                $tables = $tablesByProduct[$option['selector']] ?? [];

                if ($tables === []) {
                    $stats['skipped']++;

                    continue;
                }

                if (TemplateProduct::query()->where('name', $option['name'])->exists()) {
                    $stats['skipped']++;

                    continue;
                }

                $product = TemplateProduct::create([
                    'name' => $option['name'],
                    'is_active' => true,
                    'sort_order' => ($productOrder + 1) * 10,
                ]);
                $stats['products']++;

                foreach ($tables as $blockOrder => $table) {
                    $block = $product->blocks()->create([
                        'heading' => $this->heading($option['name'], $option['selector'], $blockOrder),
                        'sort_order' => ($blockOrder + 1) * 10,
                    ]);
                    $stats['blocks']++;

                    $rowOrder = 0;
                    foreach ($xpath->query('./tr|./tbody/tr', $table) ?: [] as $rowNode) {
                        if (! $rowNode instanceof DOMElement) {
                            continue;
                        }

                        $left = $xpath->query('./td[contains(concat(" ", normalize-space(@class), " "), " left ")]', $rowNode)?->item(0);
                        $right = $xpath->query('./td[contains(concat(" ", normalize-space(@class), " "), " right ")]', $rowNode)?->item(0);

                        if (! $left instanceof DOMElement || ! $right instanceof DOMElement) {
                            continue;
                        }

                        $links = $xpath->query('.//a[@href]', $right);
                        if ($links === false || $links->length === 0) {
                            continue;
                        }

                        $templateRow = $block->rows()->create([
                            'size_template' => $this->text($left),
                            'sort_order' => (++$rowOrder) * 10,
                        ]);
                        $stats['rows']++;

                        foreach ($links as $downloadOrder => $link) {
                            if (! $link instanceof DOMElement) {
                                continue;
                            }

                            $templateRow->downloads()->create([
                                'button_label' => $this->text($link) ?: 'テンプレートダウンロード',
                                'file_path' => $link->getAttribute('href'),
                                'original_name' => null,
                                'sort_order' => ($downloadOrder + 1) * 10,
                            ]);
                            $stats['downloads']++;
                        }
                    }
                }
            }
        });

        return $stats;
    }

    private function text(DOMElement $element): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', $element->textContent));
    }

    private function heading(string $displayName, string $selectorName, int $blockOrder): string
    {
        if ($blockOrder > 0) {
            return $displayName.'【CLIP STUDIO PAINT】';
        }

        $photoshopProducts = [
            'アクリルキーホルダー',
            'アクリルフィギュアスタンド',
            'アクリルスタンド',
            'アクリルスマホスタンド',
            'めじるしチャーム（アクリルアンブレラマーカー）',
            'アクリルクリップ（アクリルバッジ）',
            'アクリルコースター',
            'アクリルヘアバンド',
            'アクリルスマホグリップトック（アクリルグリップホルダー）',
            'テンチャックケース',
        ];

        $suffix = in_array($selectorName, $photoshopProducts, true)
            ? '【Illustrator／Photoshop】'
            : '【Illustrator】';

        return $displayName.$suffix;
    }
}
