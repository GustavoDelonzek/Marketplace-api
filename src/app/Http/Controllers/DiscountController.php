<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Services\DiscountService;

class DiscountController extends Controller
{

    public function __construct(protected DiscountService $discountService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->discountService->getAllDiscounts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        $validated = $request->validated();

        $created = $this->discountService->createDiscount($validated);

        return response()->json([
            'Message' => 'Discount created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $discount)
    {
        return response()->json($this->discountService->showDiscount($discount));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, string $discount)
    {
        $validated = $request->validated();

        $updated = $this->discountService->updateDiscount( $discount, $validated);

        return response()->json([
            'message' => 'updated successfully'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $discount)
    {
        $deleted = $this->discountService->deleteDiscount($discount);

        return response()->json([
            'message' => 'deleted successfully'
        ], 200);
    }
}
