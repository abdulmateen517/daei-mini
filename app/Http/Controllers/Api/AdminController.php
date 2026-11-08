<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    public function users(): JsonResponse
    {
        return response()->json([
            'data' => User::query()
                ->select(['id', 'name', 'email', 'role', 'created_at'])
                ->orderBy('id')
                ->paginate(50),
        ]);
    }
}
