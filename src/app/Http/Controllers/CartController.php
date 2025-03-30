<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCartItemRequest;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateQuantityCartItemRequest;
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
    public function update(UpdateQuantityCartItemRequest $request)
    {
        $validated = $request->validated();
        $updated = $this->cartService->updateCartItem(Auth::user(), $validated);

        return response()->json([
            'message' => 'Cart item updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteItem(DeleteCartItemRequest $request)
    {
        $validated = $request->validated();

        $deleted = $this->cartService->deleteCartItem(Auth::user(), $validated['product_id']);

        return response()->json([
            'message' => 'Cart item deleted successfully'
        ], 200);
    }

    public function clear()
    {
        $cleared = $this->cartService->clearCart(Auth::user());

        return response()->json([
            'message' => 'Cart cleared successfully'
        ], 200);
    }
}
