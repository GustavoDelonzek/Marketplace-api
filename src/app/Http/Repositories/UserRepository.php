<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository{
    public function createUser($user){
        return User::create($user);
    }
}
