<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\HomeNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;

class HomeNotificationController extends Controller
{
    public function show(): View
    {
        $notification = Schema::hasTable('home_notifications')
            ? HomeNotification::query()->first() ?? HomeNotification::defaultNotification()
            : HomeNotification::defaultNotification();

        return view('partials.home-notification', compact('notification'));
    }
}
