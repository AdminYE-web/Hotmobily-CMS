<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeadingPreset;
use App\Support\HeadingContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HeadingPresetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data'=>HeadingPreset::orderBy('name')->get(['id','name','updated_at'])]);
    }

    public function show(HeadingPreset $headingPreset): JsonResponse
    {
        return response()->json(['data'=>$headingPreset]);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(['data'=>HeadingPreset::create($this->validated($request))],201);
    }

    public function update(Request $request, HeadingPreset $headingPreset): JsonResponse
    {
        $headingPreset->update($this->validated($request,$headingPreset));
        return response()->json(['data'=>$headingPreset->fresh()]);
    }

    public function destroy(HeadingPreset $headingPreset): JsonResponse
    {
        $headingPreset->delete();
        return response()->json(['success'=>true]);
    }

    private function validated(Request $request, ?HeadingPreset $preset = null): array
    {
        $data=$request->validate(['name'=>['required','string','max:150',Rule::unique('heading_presets','name')->ignore($preset?->id)],'content'=>'required|array']);
        return ['name'=>trim($data['name']),'content_json'=>HeadingContent::style($data['content'])];
    }
}
