<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\OtpVerify;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OtpController extends Controller
{
    public function show(Request $request)
    {
        if (!session('verify_token')) {
            return redirect()
                ->route('admin.login');
        }

        return view('admin.auth.otp');
    }


    public function verify(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                'digits:6',
            ],
        ]);


        $hashKey = session(
            'verify_token'
        );


        if (!$hashKey) {

            return redirect()
                ->route('admin.login');

        }


        $otp = OtpVerify::where(
                'hash_id',
                $hashKey
            )
            ->where(
                'type',
                'admin_login'
            )
            ->where(
                'status',
                'pending'
            )
            ->first();


        if (!$otp) {

            return redirect()
                ->route('admin.login')
                ->withErrors([
                    'code' =>
                        'OTP is invalid or expired.',
                ]);

        }


        if ($otp->code !== $request->code) {

            return back()
                ->withErrors([
                    'code' =>
                        'OTP is incorrect.',
                ]);

        }


        return DB::transaction(
            function () use (
                $request,
                $otp
            ) {

                /*
                 * Expire OTP
                 */
                $otp->update([
                    'status' => 'verified',
                    'updated_at' => now(),
                ]);


                /*
                 * Find Admin
                 */
                $admin = Admin::where(
                    'email',
                    $otp->email
                )->firstOrFail();


                /*
                 * Login
                 */
                Auth::guard('admin')
                    ->login(
                        $admin,
                        true
                    );


                $request->session()
                    ->regenerate();


                $admin->update([
                    'last_login' => now(),
                ]);


                session()
                    ->forget(
                        'verify_token'
                    );


                /*
                 * Redirect
                 */

                return match ($admin->dept) {

                    'factory' =>
                        redirect()
                            ->route(
                                'admin.production'
                            ),

                    'coo',
                    'designer' =>
                        redirect()
                            ->route(
                                'admin.design'
                            ),

                    default =>
                        redirect()
                            ->route(
                                'admin.dashboard'
                            ),
                };

            }
        );
    }
}