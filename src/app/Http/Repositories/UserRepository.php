<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository{

    public function getUserById(int $id){
        return User::findOrFail($id)->first();
    }

    public function createUser($user){
        return User::create($user);
    }

    public function getUserByEmail($email){
        return User::where('email', $email)->first();
    }
}
