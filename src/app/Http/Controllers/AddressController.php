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

        return response()->json([
            'message' => "Created successfully"
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $address)
    {
        return response()->json($this->addressService->showAddress($address, Auth::id()), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, string $address)
    {
        $validated = $request->validated();

        $updated = $this->addressService->updateAddress($validated, $address, Auth::id());

        return response()->json([
            'message' => 'Updated successfully'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $address)
    {
        $deleted = $this->addressService->deleteAddress($address, Auth::id());

        return response()->json([
            'message' => 'Deleted successfully'
        ]);
    }
}
