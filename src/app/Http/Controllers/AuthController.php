<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailResetPasswordRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Services\UserService;
use App\Jobs\SendEmailVerification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(protected UserService $userService)
    {
    }


    public function login(LoginUserRequest $request){
        $validated = $request->validated();

        return $this->userService->login($validated);
    }

    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        return response()->json($this->userService->register($validated), 201);
    }

    public function confirmEmail(EmailVerificationRequest $request){
        if ($request->user() && $request->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already confirmed'], 200);
        }

        $request->fulfill();
        return response()->json(['message' => 'Email confirmed successfully'], 201);
    }

    public function verificationNotification(){
        SendEmailVerification::dispatch(Auth::user());
        return response()->json(['message' => 'Email verification notification sent successfully'], 201);
    }

    public function sendResetLinkEmail(EmailResetPasswordRequest $request){
        $validated = $request->validated();
        return $this->userService->sendResetLinkEmail($validated);
    }

    public function resetPassword(ResetPasswordRequest $request){
        $validated = $request->validated();
        return $this->userService->resetPassword($validated);
    }



}
