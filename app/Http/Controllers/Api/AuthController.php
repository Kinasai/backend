<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Auth\AuthRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @throws Exception
     */
    public function auth(AuthRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        try {
            if (!Auth::attempt($validated)) {
                return response()->json(['message' => 'Incorrect credentials.'], 401);
            }

            $user = Auth::user();

            $token = $this->getOrCreateToken($user, 'api-token');
            return response()->json([
                'token' => $token,
                'user' => $user
            ]);
        } catch (Exception $exception) {
            throw new Exception(
                $exception->getMessage(),
            );
        }
    }
    /**
     * Выход пользователя (удаление текущего токена).
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'You have successfully logged out.']);
    }

    /**
     * @throws Exception
     */
    public function register(RegisterRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validated = $request->validated();

            User::query()->create([
                'login' => $validated['login'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);
        } catch (Exception $exception) {
            throw new Exception(
                $exception->getMessage(),
            );
        }


        return response()->json(['message' => 'You have registered successfully.']);
    }

    private function getOrCreateToken($user, $tokenName)
    {
        $user->tokens()->where('name', $tokenName)->delete();
        return $user->createToken($tokenName)->plainTextToken;
    }

    public function profile(Request $request): \Illuminate\Http\JsonResponse
    {
        return $request->user();

    }
}
