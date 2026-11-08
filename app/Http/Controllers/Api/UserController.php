<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request, User $user): JsonResponse
    {
        abort_unless($request->user()->isAdmin() || $request->user()->is($user), JsonResponse::HTTP_FORBIDDEN);

        return response()->json(['data' => $user]);
    }
}
