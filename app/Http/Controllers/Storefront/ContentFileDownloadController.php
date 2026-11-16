<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Support\TextLinkDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentFileDownloadController extends Controller
{
    public function __invoke(Request $request, string $kind, string $record, string $filename)
    {
        $path = $kind.'/'.$record.'/content-files/'.$filename;
        abort_unless(preg_match(TextLinkDownload::pathPattern(), $path), 404);
        $disk = Storage::disk('public');
        abort_unless($disk->exists($path), 404);
        $data = $request->validate(['name' => ['nullable', 'string', 'max:255']]);
        $name = TextLinkDownload::filename($data['name'] ?? '') ?: $filename;
        return $disk->download($path, $name, ['X-Content-Type-Options' => 'nosniff']);
    }
}
