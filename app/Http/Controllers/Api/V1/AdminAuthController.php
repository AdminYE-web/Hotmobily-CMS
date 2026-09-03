<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([

            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],

            'device_name' => [
                'required',
                'string',
                'max:255',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Login แบบ Database เดิม
        |--------------------------------------------------------------------------
        */

        $admin = Admin::where(
                'email',
                $request->email
            )
            ->where(
                'pass',
                $request->password
            )
            ->first();


        if (!$admin) {

            return response()->json([
                'success' => false,
                'message' =>
                    'Email or password is incorrect.',
            ], 401);

        }


        /*
        |--------------------------------------------------------------------------
        | Create API Token
        |--------------------------------------------------------------------------
        */

        $token = $admin
            ->createToken(
                $request->device_name
            )
            ->plainTextToken;


        return response()->json([

            'success' => true,

            'data' => [

                'admin' => [
                    'email' => $admin->email,
                    'username' => $admin->user,
                    'staff_name' => $admin->staff_name,
                    'dept' => $admin->dept,
                    'lang' => $admin->lang,
                ],

                'token' => $token,

            ],

        ]);
    }


    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();


        return response()->json([
            'success' => true,
            'message' => 'Logged out.',
        ]);
    }
}