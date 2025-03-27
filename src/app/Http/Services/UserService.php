<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Hash;

class UserService{
    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function login($user){
        $loginUser = $this->userRepository->getUserByEmail($user['email']);

        if(!$user || !Hash::check($user['password'], $loginUser->password)){
            throw new Error('Invalid credentials', 401);
        }

        $token = $loginUser->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $loginUser
        ]);
    }

    public function register($user){
        $user['password'] = Hash::make($user['password']);
        return $this->userRepository->createUser($user);
    }

    public function updateMe(User $user, $userUpdates){
        return $this->userRepository->updateUser($user, $userUpdates);
    }

    public function deleteMe(User $user){
        return $this->userRepository->deleteUser($user);
    }
}
