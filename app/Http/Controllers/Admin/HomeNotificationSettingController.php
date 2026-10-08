<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeNotification;
use App\Support\RichTextSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeNotificationSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.home-settings.notification.edit', [
            'notification' => $this->notification(),
        ]);
    }

    public function update(Request $request, RichTextSanitizer $sanitizer): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:20000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $notification = $this->notification();
        $notification->update([
            'title' => trim($data['title']),
            'message' => $sanitizer->sanitize($data['message'] ?? ''),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.home-settings.notification.edit')
            ->with('status', 'Home Notification updated.');
    }

    private function notification(): HomeNotification
    {
        return HomeNotification::query()->firstOrCreate(
            ['id' => 1],
            [
                'title' => 'お知らせ',
                'message' => '現在お知らせはありません。',
                'is_active' => true,
            ]
        );
    }
}
