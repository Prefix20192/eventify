<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\TelegramAuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function handleTelegramAuth(TelegramAuthRequest $request): JsonResponse
    {
        try {
            $userData = $request->user_data;

            $user = User::query()->firstOrCreate(
                ['telegram_id' => $userData['id']],
                [
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'] ?? null,
                    'username' => $userData['username'] ?? null,
                    'photo_url' => $userData['photo_url'] ?? null,
                    'password' => bcrypt(Str::random(32))
                ]
            );

            $token = $user->createToken('telegram-token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'telegram_id' => $user->telegram_id,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'username' => $user->username,
                    'photo_url' => $user->photo_url
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Auth error: '.$e->getMessage());
            return response()->json([
                'error' => 'Authentication failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getUser(Request $request)
    {
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'id' => $request->user()->id,
            'telegram_id' => $request->user()->telegram_id,
            'first_name' => $request->user()->first_name,
            'last_name' => $request->user()->last_name,
            'username' => $request->user()->username,
            'photo_url' => $request->user()->photo_url
        ]);
    }
}
