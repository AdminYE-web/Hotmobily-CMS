<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class LegacyMockController extends Controller
{
    public function info(): View
    {
        return view('mocks.legacy-info');
    }

    public function reviews(): View
    {
        return view('mocks.legacy-reviews');
    }

    public function language(): Response
    {
        return response('jp')->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
