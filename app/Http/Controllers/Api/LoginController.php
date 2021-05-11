<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (auth()->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]))
        {
            $user = auth()->user();
            $user->api_token = Str::random(60);
            $user->save();

            return $user;
        }

        return response()->json([
            'message' => 'The user is not registered with us'
        ]);
    }

    public function logout()
    {
        if (auth()->user())
        {
            $user = auth()->user();
            $user->api_token = null;
            $user->save();
            return response()->json([
                'message' => 'Logout'
            ]);
        }
        return response()->json([
            'error' => 'You are not authorized',
        ]);
    }
}
