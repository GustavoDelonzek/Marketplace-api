<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCartItemRequest;
use App\Http\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(protected CartService $cartService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->cartService->getAllCartsByUser(Auth::user()->id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartItemRequest $request)
    {
        $validated = $request->validated();
        $created = $this->cartService->createCartItem(Auth::user(), $validated);
        return response()->json([
            'message' => 'Cart item created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        return $this->cartService->showCart(Auth::user()->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
