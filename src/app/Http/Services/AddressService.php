<?php

namespace App\Http\Services;

use App\Exceptions\Business\NothingToUpdateException;
use App\Exceptions\Http\UnauthorizedException;
use App\Http\Repositories\AddressRepository;
use App\Http\Resources\AddressResource;


class AddressService{
    public function __construct(protected AddressRepository $addressRepository)
    {
    }

    public function addressUser($userId){
        $addresses = $this->addressRepository->getAllAddressByUser($userId);
        return AddressResource::collection($addresses);
    }

    public function createAddress(int $userId, $addressData){
        $addressData['user_id'] = $userId;

        return $this->addressRepository->createAddress($addressData);
    }

    public function showAddress(int $addressId, int $userLogado){
        $address = $this->addressRepository->getAddressById($addressId);

        if($address->user_id !== $userLogado){
            throw new UnauthorizedException();
        }

        return new AddressResource($address);
    }

    public function updateAddress($addressData, $addressId, $userId){
        $address = $this->addressRepository->getAddressById($addressId);

        if(empty($addressData)){
            throw new NothingToUpdateException();
        }

        if($address->user_id !== $userId){
            throw new UnauthorizedException();
        }

        return $this->addressRepository->updateAddress($addressId, $addressData);
    }

    public function deleteAddress($addressId, $userId){
        $address = $this->addressRepository->getAddressById($addressId);

        if($address->user_id !== $userId){
            throw new UnauthorizedException();
        }

        return $this->addressRepository->deleteAddress($addressId);
    }

}
