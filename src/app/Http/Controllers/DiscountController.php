<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Services\DiscountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $created = $this->discountService->createDiscount(Auth::user(), $validated);

        return response()->json([
            'Message' => 'Discount created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
