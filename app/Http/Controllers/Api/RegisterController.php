<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:191|string',
            'email' => 'required|email|max:191|unique:users|string',
            'password' => 'required|max:191|string',
        ],[
            'name.required' => 'This field is required'
        ]);
        if ($validator->fails())
        {
            return $validator->errors();
        }
        else
        {
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'api_token' => Str::random(60),
            ]);

            return $data;
        }
    }
}
