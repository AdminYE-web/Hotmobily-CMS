<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FaqController extends Controller
{
    /**
     * FAQ List
     */
    public function index(Request $request)
    {
        $query = Faq::query();

        if ($request->filled('category')) {
            $query->where(
                'category',
                $request->string('category')
            );
        }

        if ($request->filled('material')) {
            $query->where(
                'material',
                $request->string('material')
            );
        }

        $faqs = $query
            ->orderBy('category')
            ->orderBy('material')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return response()->json([
            'data' => $faqs,
        ]);
    }


    /**
     * Create a Product or FAQ entry
     */
    public function store(Request $request)
    {
        $data = $this->normalizeData(
            $this->validateData($request)
        );

        $faq = Faq::create($data);

        return response()->json([
            'message' => $data['entry_type'] === 'product'
                ? 'Product created successfully.'
                : 'FAQ created successfully.',
            'data' => $faq,
        ], 201);
    }


    /**
     * Show FAQ
     */
    public function show(Faq $faq)
    {
        return response()->json([
            'data' => $faq,
        ]);
    }


    /**
     * Update FAQ
     */
    public function update(
        Request $request,
        Faq $faq
    ) {
        $data = $this->normalizeData(
            $this->validateData($request)
        );

        $faq->update($data);

        return response()->json([
            'message' => $data['entry_type'] === 'product'
                ? 'Product updated successfully.'
                : 'FAQ updated successfully.',
            'data' => $faq->fresh(),
        ]);
    }


    /**
     * Delete FAQ
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json([
            'message' => 'FAQ deleted successfully.',
        ]);
    }


    /**
     * Normalize Product and FAQ data before persistence.
     */
    private function normalizeData(array $data): array
    {
        if ($data['entry_type'] === 'product') {
            if ($data['category'] !== 'product') {
                throw ValidationException::withMessages([
                    'category' => 'Product entries must use the product category.',
                ]);
            }

            $data['product_id'] = null;
            $data['question'] = '';
            $data['answer'] = '';

            return $data;
        }

        if ($data['category'] === 'product') {
            $product = !empty($data['product_id'])
                ? Faq::query()
                    ->whereKey($data['product_id'])
                    ->where('entry_type', 'product')
                    ->where('category', 'product')
                    ->first()
                : null;

            if (!$product) {
                throw ValidationException::withMessages([
                    'product_id' => 'Please select a valid Product.',
                ]);
            }

            $data['material'] = $product->material;
        } else {
            $data['product_id'] = null;
            $data['material'] = null;
        }

        $data['question_name'] = null;
        $data['product_link'] = null;
        $data['product_link_text'] = null;

        return $data;
    }


    /**
     * Validation
     */
    private function validateData(
        Request $request
    ): array {
        return $request->validate([
            'entry_type' => [
                'required',
                'string',
                'in:product,faq',
            ],

            'category' => [
                'required',
                'string',
                'in:product,order,delivery,payment',
            ],

            'product_id' => [
                'nullable',
                'integer',
                'exists:faqs,id',
                Rule::requiredIf(
                    fn (): bool => $request->input('entry_type') === 'faq'
                        && $request->input('category') === 'product'
                ),
            ],

            'material' => [
                'nullable',
                'string',
                'max:100',
                'required_if:entry_type,product',
            ],

            'question_name' => [
                'nullable',
                'string',
                'max:500',
                'required_if:entry_type,product',
            ],

            'product_link' => [
                'nullable',
                'string',
                'max:2000',
                'required_if:entry_type,product',
            ],

            'product_link_text' => [
                'nullable',
                'string',
                'max:500',
                'required_if:entry_type,product',
            ],

            'question' => [
                'nullable',
                'string',
                'max:500',
                'required_if:entry_type,faq',
            ],

            'answer' => [
                'nullable',
                'string',
                'required_if:entry_type,faq',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'is_active' => [
                'required',
                'boolean',
            ],
        ]);
    }
}
