<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use App\Http\Traits\CanLoadRelationships;
use App\Jobs\SendEmailWelcome;
use App\Models\User;
use Error;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService{
    use CanLoadRelationships;

    private array $relations = ['addresses', 'orders', 'cart', 'cart.cartItems', 'cart.cartItems.product' , 'orders.orderItems', 'orders.orderItems.product'];

    public function __construct(protected UserRepository $userRepository)
    {
    }

    public function login($user){
        $loginUser = $this->userRepository->getUserByEmail($user['email']);

        if(!$user || !Hash::check($user['password'], $loginUser->password)){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Invalid credentials',
                ], 401));
        }

        $token = $loginUser->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $loginUser
        ]);
    }

    public function register($user){
        $user['password'] = Hash::make($user['password']);
        $newUser = $this->userRepository->createUser($user);
        SendEmailWelcome::dispatch($newUser);
        return $newUser;
    }

    public function showMe($user){
        $query = $this->loadRelationships($user);

        return $query;
    }

    public function updateMe(User $user, $userUpdates){
        return $this->userRepository->updateUser($user, $userUpdates);
    }

    public function deleteMe(User $user){
        return $this->userRepository->deleteUser($user);
    }

    public function createModerator(User $user, $newUser){
        $newUser['role'] = 'moderator';

        return $this->userRepository->createUser($newUser);
    }

    public function updateImage(User $user, $image){
        $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension();

        if($user->image_path){
            Storage::delete($user->image_path);
        }

        $path = Storage::putFileAs('public/categories', $image, $imageName);

        return $this->userRepository->updateImage($user, $path);
    }

    public function showImage(User $user)
    {
        if (!Storage::exists($user->image_path)) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Image not found',
                ], 404)
            );
        }

        $file = Storage::get($user->image_path);
        $mime = Storage::mimeType($user->image_path);

        return response()->make($file, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline',
        ]);
    }
}
