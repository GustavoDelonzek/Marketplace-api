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

    public function updateUser(User $user, $userUpdates){
        return $user->update($userUpdates);
    }

    public function deleteUser(User $user){
        return $user->delete();
    }

}
