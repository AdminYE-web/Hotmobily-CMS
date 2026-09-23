<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPageLayout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomPageLayoutController extends Controller
{
    private const ALLOWED_TYPES = [
        'heading',
        'head_section',
        'head_sub_section',
        'rich_text',
        'image',
        'multi_photo',
        'youtube',
        'button',
        'template_button',
        'text_link',
        'custom_table',
        'info_card',
        'accordion',
        'divider',
        'spacer',
    ];

    private const ALLOWED_CHILD_TYPES = [
        'heading',
        'head_section',
        'head_sub_section',
        'rich_text',
        'image',
        'multi_photo',
        'youtube',
        'button',
        'template_button',
        'text_link',
        'custom_table',
        'info_card',
        'divider',
        'spacer',
    ];

    public function index(): JsonResponse
    {
        $layouts = CustomPageLayout::query()
            ->withCount('pages')
            ->latest()
            ->get()
            ->each(function (CustomPageLayout $layout): void {
                $layout->setAttribute(
                    'components_count',
                    $this->countBlocks($layout->draft_layout_json['rows'] ?? [])
                );
            });

        return response()->json([
            'success' => true,
            'data' => $layouts,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validateDetails($request);

        $layout = CustomPageLayout::query()->create([
            ...$data,
            'status' => 'draft',
            'draft_layout_json' => [
                'version' => 2,
                'rows' => [],
            ],
        ]);

        return response()->json([
            'success' => true,
            'data' => $layout,
        ], 201);
    }

    public function show(CustomPageLayout $customPageLayout): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customPageLayout,
        ]);
    }

    public function update(Request $request, CustomPageLayout $customPageLayout): JsonResponse
    {
        $customPageLayout->update($this->validateDetails($request, $customPageLayout));

        return response()->json([
            'success' => true,
            'data' => $customPageLayout->fresh(),
        ]);
    }

    public function saveLayout(Request $request, CustomPageLayout $customPageLayout): JsonResponse
    {
        $data = $request->validate([
            'rows' => ['present', 'array', 'max:200'],
            'rows.*.id' => ['required', 'string', 'max:100'],
            'rows.*.region' => ['nullable', 'string'],
            'rows.*.columns' => ['present', 'array', 'min:1', 'max:3'],
            'rows.*.columns.*.id' => ['required', 'string', 'max:100'],
            'rows.*.columns.*.width' => ['required', 'integer', Rule::in([4, 6, 8, 12])],
            'rows.*.columns.*.blocks' => ['present', 'array', 'max:100'],
            'rows.*.columns.*.blocks.*.id' => ['required', 'string', 'max:100'],
            'rows.*.columns.*.blocks.*.type' => ['required', 'string', Rule::in(self::ALLOWED_TYPES)],
            'rows.*.columns.*.blocks.*.settings' => ['present', 'array'],
            'rows.*.columns.*.blocks.*.children' => ['nullable', 'array', 'max:50'],
            'rows.*.columns.*.blocks.*.children.*.id' => ['required', 'string', 'max:100'],
            'rows.*.columns.*.blocks.*.children.*.type' => ['required', 'string', Rule::in(self::ALLOWED_CHILD_TYPES)],
            'rows.*.columns.*.blocks.*.children.*.settings' => ['present', 'array'],
        ]);

        $rowIds = [];
        $columnIds = [];
        $blockIds = [];
        $effectiveIds = [];

        foreach ($data['rows'] as &$row) {
            $row['region'] = 'before_order';

            if (isset($rowIds[$row['id']])) {
                return $this->layoutError('Duplicate Row ID found: '.$row['id']);
            }

            $rowIds[$row['id']] = true;
            $totalWidth = 0;

            foreach ($row['columns'] as $column) {
                $totalWidth += (int) $column['width'];

                if (isset($columnIds[$column['id']])) {
                    return $this->layoutError('Duplicate Column ID found: '.$column['id']);
                }

                $columnIds[$column['id']] = true;

                foreach ($column['blocks'] as $block) {
                    if ($error = $this->registerBlock($block, $blockIds, $effectiveIds)) {
                        return $this->layoutError($error);
                    }

                    if ($block['type'] !== 'accordion' && ! empty($block['children'] ?? [])) {
                        return $this->layoutError('Only Accordion components may contain child components.');
                    }

                    foreach ($block['children'] ?? [] as $child) {
                        if ($error = $this->registerBlock($child, $blockIds, $effectiveIds)) {
                            return $this->layoutError($error);
                        }
                    }
                }
            }

            if ($totalWidth !== 12) {
                return $this->layoutError('Each row must have a total column width of 12.');
            }
        }
        unset($row);

        $layoutJson = [
            'version' => 2,
            'rows' => $data['rows'],
        ];

        $customPageLayout->update(['draft_layout_json' => $layoutJson]);

        return response()->json([
            'success' => true,
            'message' => 'Custom Page layout draft saved.',
            'data' => ['draft_layout_json' => $layoutJson],
        ]);
    }

    public function publish(CustomPageLayout $customPageLayout): JsonResponse
    {
        $draft = $customPageLayout->draft_layout_json;

        if (empty($draft) || $this->countBlocks($draft['rows'] ?? []) === 0) {
            return $this->layoutError('Please add at least one component before publishing.');
        }

        $customPageLayout->update([
            'published_layout_json' => $draft,
            'status' => 'published',
            'published_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Custom Page layout published successfully.',
            'data' => ['published_at' => $customPageLayout->fresh()->published_at],
        ]);
    }

    public function destroy(CustomPageLayout $customPageLayout): JsonResponse
    {
        if ($customPageLayout->pages()->exists()) {
            return $this->layoutError('This layout is currently used by a Custom Page.');
        }

        $customPageLayout->delete();

        return response()->json([
            'success' => true,
            'message' => 'Custom Page layout deleted.',
        ]);
    }

    private function validateDetails(Request $request, ?CustomPageLayout $layout = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'alpha_dash',
                'max:255',
                Rule::unique('custom_page_layouts', 'slug')->ignore($layout?->id),
            ],
            'description' => ['nullable', 'string', 'max:500'],
        ]);
    }

    private function registerBlock(array $block, array &$blockIds, array &$effectiveIds): ?string
    {
        $id = $block['id'];

        if (isset($blockIds[$id])) {
            return 'Duplicate internal Block ID found: '.$id;
        }

        $blockIds[$id] = true;
        $customId = trim((string) ($block['settings']['custom_id'] ?? ''));

        if ($customId !== '' && ! preg_match('/^[A-Za-z][A-Za-z0-9_-]*$/', $customId)) {
            return 'Invalid custom Block ID: '.$customId;
        }

        $effectiveId = $customId !== '' ? $customId : $id;
        $effectiveKey = mb_strtolower($effectiveId);

        if (isset($effectiveIds[$effectiveKey])) {
            return 'Duplicate Block ID found: '.$effectiveId;
        }

        $effectiveIds[$effectiveKey] = true;

        return null;
    }

    private function countBlocks(array $rows): int
    {
        $count = 0;

        foreach ($rows as $row) {
            foreach ($row['columns'] ?? [] as $column) {
                foreach ($column['blocks'] ?? [] as $block) {
                    $count += 1 + count($block['children'] ?? []);
                }
            }
        }

        return $count;
    }

    private function layoutError(string $message): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 422);
    }
}
