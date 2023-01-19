<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessTokensController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', '=', $request->post('email'))->first();
        if ($user && Hash::check($request->post('password'), $user->password)) {
            // Create access token and return it as response

            $token = $user->createToken($request->userAgent(), [
                'categories.create', 'categories.update'
            ]);

            return [
                'token' => $token->plainTextToken,
                'user' => $user,
            ];
        }

        return response([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function destroy()
    {
        $user = Auth::guard('sanctum')->user();

        // Delete the current access token
        $user->currentAccessToken()->delete();

        // Delete all access token (Logout from all devices!)
        // $user->tokens()->delete();

        return [
            'message' => 'token revoked',
        ];
    }
}
