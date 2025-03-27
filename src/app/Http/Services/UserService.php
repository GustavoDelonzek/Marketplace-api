<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function register($user){
        $user['password'] = Hash::make($user['password']);
        return $this->userRepository->createUser($user);
    }
}
