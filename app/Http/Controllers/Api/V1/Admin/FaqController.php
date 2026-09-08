<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

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
     * Create FAQ
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        if ($data['category'] !== 'product') {
            $data['material'] = null;
            $data['question_name'] = null;
            $data['product_link'] = null;
            $data['product_link_text'] = null;
        }

        $faq = Faq::create($data);

        return response()->json([
            'message' => 'FAQ created successfully.',
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
        $data = $this->validateData($request);

        if ($data['category'] !== 'product') {
            $data['material'] = null;
            $data['question_name'] = null;
            $data['product_link'] = null;
            $data['product_link_text'] = null;
        }

        $faq->update($data);

        return response()->json([
            'message' => 'FAQ updated successfully.',
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
     * Validation
     */
    private function validateData(
        Request $request
    ): array {
        return $request->validate([
            'category' => [
                'required',
                'string',
                'in:product,order,delivery,payment',
            ],

            'material' => [
                'nullable',
                'string',
                'max:100',
                'required_if:category,product',
            ],

            'question_name' => [
                'nullable',
                'string',
                'max:500',
                'required_if:category,product',
            ],

            'product_link' => [
                'nullable',
                'string',
                'max:2000',
                'required_if:category,product',
            ],

            'product_link_text' => [
                'nullable',
                'string',
                'max:500',
                'required_if:category,product',
            ],

            'question' => [
                'required',
                'string',
                'max:500',
            ],

            'answer' => [
                'required',
                'string',
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
