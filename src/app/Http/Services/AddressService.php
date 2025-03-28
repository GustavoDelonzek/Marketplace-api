<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use Error;

class AddressService{
    public function __construct(protected AddressRepository $addressRepository)
    {
    }

    public function addressUser($userId){
        return $this->addressRepository->getAllAddressByUser($userId);
    }

    public function createAddress(int $userId, $addressData){
        $addressData['user_id'] = $userId;

        return $this->addressRepository->createAddress($addressData);
    }

    public function showAddress(int $addressId, int $userLogado){
        $address = $this->addressRepository->getAddressById($addressId);

        if($address->user_id !== $userLogado){
            throw new Error("Permission denied to access this address ", 401);
        }

        return $address;
    }

    public function updateAddress($addressData, $addressId, $userId){
        $address = $this->addressRepository->getAddressById($addressId);

        if($address->user_id !== $userId){
            throw new Error('Permission denied to update this address');
        }
        $updated = $this->addressRepository->updateAddress($addressId, $addressData);

        return response()->json([
            'message' => 'Updated successfully'
        ]);
    }

    public function deleteAddress($addressId, $userId){
        $address = $this->addressRepository->getAddressById($addressId);

        if($address->user_id !== $userId){
            throw new Error('Permission denied to delete this address');
        }

        $deleted = $this->addressRepository->deleteAddress($addressId);

        return response()->json([
            'message' => 'Deleted successfully'
        ]);

    }

}
