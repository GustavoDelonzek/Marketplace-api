<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(protected UserService $userService)
    {
    }

    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        return response()->json($this->userService->register($validated), 201);
    }
}
