<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        return $this->tokenResponse($user, 'api-registration', JsonResponse::HTTP_CREATED);
    }

    public function login(Request $request): JsonResponse
    {
        return $this->authenticate($request, false);
    }

    public function adminLogin(Request $request): JsonResponse
    {
        return $this->authenticate($request, true);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            $token->delete();
        }

        return response()->json(['message' => 'Logged out successfully.']);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json(['data' => $request->user()]);
    }

    private function authenticate(Request $request, bool $adminOnly): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate($validated)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        $user = User::query()->where('email', $validated['email'])->firstOrFail();

        abort_if($adminOnly && ! $user->isAdmin(), JsonResponse::HTTP_FORBIDDEN);

        return $this->tokenResponse($user, $adminOnly ? 'admin-api-login' : 'api-login');
    }

    private function tokenResponse(User $user, string $tokenName, int $status = JsonResponse::HTTP_OK): JsonResponse
    {
        $token = $user->createToken($tokenName, ['*'], now()->addDays(7))->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], $status);
    }
}
