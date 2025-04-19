<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->orderService->allOrders(Auth::user()->id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        $created = $this->orderService->createOrder(Auth::user(), $validated);
        return response()->json([
            'message' => 'Order created successfully!'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $order)
    {
        return $this->orderService->showOrder(Auth::id(), $order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $order)
    {
        $validated = $request->validated();
        $updated = $this->orderService->updateStatus($validated, $order);

        return response()->json([
            'message' => 'Status updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $order)
    {
        $canceled = $this->orderService->cancelOrder(Auth::user(), $order);
        return response()->json([
            'message' => 'Order canceled successfully'
        ], 200);
    }

    /**
     * Create a relatory weekly order
     */

     public function relatoryWeekly(){
         return $this->orderService->createRelatoryWeeklyOrder();
     }
}
