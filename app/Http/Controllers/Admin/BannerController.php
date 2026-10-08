<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function edit(): View
    {
        $headerBanner = Banner::query()->firstOrNew(
            ['slot' => 'header'],
            [
                'alt_text' => 'Hotmobily',
                'is_active' => true,
            ]
        );
        $contactBanner = Banner::query()->firstOrNew(
            ['slot' => 'contact'],
            [
                'alt_text' => 'Contact Hotmobily',
                'is_active' => true,
            ]
        );

        return view('admin.banners.edit', compact('headerBanner', 'contactBanner'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'slot' => ['required', 'in:header,contact'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif,webp,avif', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'string', 'max:2000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slot = $data['slot'];
        $banner = Banner::query()->firstOrNew(['slot' => $slot]);

        if ($request->boolean('remove_image') && $banner->image_path) {
            Storage::disk('public')->delete($banner->image_path);
            $banner->image_path = null;
        }

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete($banner->image_path);
            }

            $banner->image_path = $request->file('image')->store('banners', 'public');
        }

        $banner->alt_text = trim((string) ($data['alt_text'] ?? '')) ?: null;
        $banner->link_url = trim((string) ($data['link_url'] ?? '')) ?: null;
        $banner->is_active = $request->boolean('is_active');
        $banner->slot = $slot;
        $banner->save();

        return redirect()
            ->route('admin.banner.edit')
            ->with('status', ucfirst($slot).' banner settings were saved.');
    }
}
