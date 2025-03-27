<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;

class AddressService{
    public function __construct(protected AddressRepository $addressRepository)
    {
    }

    public function addressUser($userId){
        return $this->addressRepository->getAllAddressByUser($userId);
    }

    
}
