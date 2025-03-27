<?php

namespace App\Http\Repositories;

use App\Models\Address;

class AddressRepository{
    public function getAllAddressByUser($userId){
        return Address::where('user_id', $userId)->get();
    }

    public function createAddress($address){
        return Address::create($address);
    }

    public function getAddressById($addressId){
        return Address::findOrFail($addressId);
    }

}
