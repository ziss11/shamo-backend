<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function callback(Request $request)
    {
        try {
            $tokenId = $request->input('token_id');
            $user = Socialite::driver('google')->userFromToken($tokenId);

            if ($user) {
                $user = User::updateOrCreate([
                    'google_id' => $user->id,
                ], [
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_token' => $user->token,
                    'google_refresh_token' => $user->refreshToken,
                ]);

                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Berhasil',
                    'data' => [
                        'token_type' => 'Bearer',
                        'access_token' => $token,
                        'user' => $user,
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Token ID tidak valid',
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Terjadi kesalahan pada server',
            ], 500);
        }
    }
}
