<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterFormRequest $request): JsonResponse
    {
        $user = User::create([
            'name'         => $request->get('name'),
            'email'        => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'password'     => Hash::make($request->get('password')),
        ]);

        \Auth::attempt($request->only('email', 'password'));

        event(new Registered($user));

        return response()->json([
            'status' => 'valid',
        ]);
    }
}
