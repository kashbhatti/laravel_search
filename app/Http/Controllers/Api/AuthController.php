<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * API Login
     */
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        $request->validated($request->all());

        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = User::firstWhere('email', $request->email);

        return response()->json([
            'message' => 'Success',
            'token' => $user->createToken('API token for '.$user->email)->plainTextToken,
        ], Response::HTTP_OK);
    }
}
