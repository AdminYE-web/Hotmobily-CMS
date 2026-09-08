<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaqImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'upload' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,gif,webp',
                'max:5120',
            ],
        ]);

        $file = $request->file('upload');

        $path = $file->store(
            'faq/' . now()->format('Y/m'),
            'public'
        );

        return response()->json([
            'url' => Storage::disk('public')
                ->url($path),
        ]);
    }
}