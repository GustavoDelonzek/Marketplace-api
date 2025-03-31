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

    public function addressIsFromUser($addressId, $userId){
        return Address::where('id', $addressId)->where('user_id', $userId)->exists();
    }

    public function updateAddress($addressId,$addressData){
        return Address::where('id', $addressId)->update($addressData);
    }

    public function deleteAddress($addressId){
        return Address::where('id', $addressId)->delete();
    }

}
