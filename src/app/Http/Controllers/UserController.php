<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Services\UserService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function showMe()
    {
        return Auth::user();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeModerator(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        return response()->json($this->userService->createModerator(Auth::user(), $validated));
    }



    /**
     * Update the specified resource in storage.
     */
    public function updateMe(UpdateUserRequest $request)
    {
        $validated = $request->validated();
        $update = $this->userService->updateMe(Auth::user(), $validated);

        return response()->json([
            'message' => 'Update successfully'
        ], 202);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteMe()
    {
        $delete = $this->userService->deleteMe(Auth::user());

        if(!$delete){
            throw new Error('Delete unsuccessfully', 406);
        }

        return response()->json([
            'message' => 'Deleted successfully'
        ], 204);
    }
}
