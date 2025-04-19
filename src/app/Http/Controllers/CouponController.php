<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenewCouponRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Services\CouponService;


class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->couponService->getAllCoupons());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        $validated = $request->validated();

        $created = $this->couponService->createCoupon($validated);

        return response()->json([
            'message' => 'Coupon created successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $coupon)
    {
        return $this->couponService->showCoupon($coupon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, string $coupon)
    {
        $validated = $request->validated();

        $updated = $this->couponService->updateCoupon($coupon, $validated);

        return response()->json([
            'message' => 'Coupon updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $coupon)
    {
        $deleted = $this->couponService->deleteCoupon($coupon);
        return response()->json([
            'message' => 'deleted successfully'
        ], 200);
    }

    public function disabledCoupons()
    {
        return $this->couponService->getDisabledCoupons();
    }

    public function renewCoupon(string $coupon, RenewCouponRequest $request){
        $validated = $request->validated();

        $updated = $this->couponService->renewCoupon($coupon, $validated);

        return response()->json([
            'message' => 'Coupon updated successfully'
        ], 200);
    }
}
