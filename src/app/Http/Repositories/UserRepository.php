<?php

namespace App\Http\Repositories;

use App\Models\Cart;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository{

    public function getUserById(int $id){
        return User::findOrFail($id)->first();
    }

    public function createUser($user){
        DB::beginTransaction();
        try{
            $createdUser = User::create($user);
            $cart = Cart::create([
                'user_id' => $createdUser->id
            ]);
            DB::commit();
            return $createdUser;
        }
        catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
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

    public function updateImage(User $user, $image){
        return $user->update([
            'image_path' => $image
        ]);
    }

}
