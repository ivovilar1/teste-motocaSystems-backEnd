<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = request()->validate([
            'email'    => 'required',
            'password' => 'required',
        ]);

        if(!auth()->attempt($data)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        $token = $request->user()->createToken('authToken')->plainTextToken;
        return [
            'access_token' => $token,
        ];
    }
}
