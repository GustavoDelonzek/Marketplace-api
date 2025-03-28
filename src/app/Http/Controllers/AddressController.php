<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Services\AddressService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct(protected AddressService $addressService)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->addressService->addressUser(Auth::id());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $validated = $request->validated();

        $address = $this->addressService->createAddress(Auth::id(), $validated);

        if(!$address){
            throw new Error('Error creating address');
        }

        return response()->json([
            'message' => "Created successfully"
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $address)
    {
        return response()->json([
            'address' => $this->addressService->showAddress($address, Auth::id())
        ], 202);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, int $address)
    {
        $validated = $request->validated();

        return $this->addressService->updateAddress($validated, $address, Auth::id());

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $address)
    {
        return $this->addressService->deleteAddress($address, Auth::id());
    }
}
