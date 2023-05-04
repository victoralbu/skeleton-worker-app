<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TokenFormRequest;
use Auth;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function token(TokenFormRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details!'
            ], 401);
        }

        return response()->json([
            'status' => 'valid',
        ]);
    }
}
