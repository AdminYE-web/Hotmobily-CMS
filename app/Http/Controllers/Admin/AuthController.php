<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminLoginOtpMail;
use App\Models\Admin;
use App\Models\OtpVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => [
            'required',
            'email',
        ],

        'password' => [
            'required',
            'string',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Check Login เหมือน PHP เดิม
    |--------------------------------------------------------------------------
    */

    $admin = Admin::where('email', $credentials['email'])
        ->where('pass', $credentials['password'])
        ->first();

    if (!$admin) {
        return back()
            ->withErrors([
                'email' => '入力内容に誤りがないかご確認ください。',
            ])
            ->onlyInput('email');
    }

    /*
    |--------------------------------------------------------------------------
    | Super Admin
    |--------------------------------------------------------------------------
    */

    if ($admin->super_admin) {
        return $this->completeLogin(
            $request,
            $admin
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Normal Admin -> OTP
    |--------------------------------------------------------------------------
    */

    return DB::transaction(function () use ($admin) {

        OtpVerify::where('email', $admin->email)
            ->where('type', 'admin_login')
            ->where('status', 'pending')
            ->update([
                'status' => 'expired',
                'updated_at' => now(),
            ]);

        $hashKey = Str::random(12);
        $reference = strtoupper(Str::random(8));
        $code = (string) random_int(100000, 999999);

        OtpVerify::create([
            'hash_id' => $hashKey,
            'type' => 'admin_login',
            'ref' => $reference,
            'code' => $code,
            'email' => $admin->email,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        Mail::to($admin->email)
            ->send(
                new AdminLoginOtpMail(
                    admin: $admin,
                    code: $code,
                    reference: $reference
                )
            );

        session([
            'verify_token' => $hashKey,
        ]);

        return redirect()->route('admin.otp');
    });
}

   private function completeLogin(
    Request $request,
    Admin $admin
) {
    Auth::guard('admin')->login($admin);

    $request->session()->regenerate();

    DB::table('admin')
        ->where('email', $admin->email)
        ->update([
            'last_login' => now(),
        ]);

    return match ($admin->dept) {

        'factory' =>
            redirect()->route('admin.production'),

        'coo',
        'designer' =>
            redirect()->route('admin.design'),

        default =>
            redirect()->route('admin.dashboard'),
    };
}

    public function logout(Request $request)
    {
        Auth::guard('admin')
            ->logout();

        $request->session()
            ->invalidate();

        $request->session()
            ->regenerateToken();

        return redirect()
            ->route('admin.login');
    }
}
