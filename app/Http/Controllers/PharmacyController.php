<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PharmacyRequest;
use App\pharmacy;

class PharmacyController extends Controller
{


    /**
     * Store Pharmacies
     */
    public function store(PharmacyRequest $request)
    {
        try {
            //get request data
            $data = $request->all();
            $query = new pharmacy();
            if (isset($data['name']))
                $query->name = $data['name'];
            if (isset($data['phone_number']))
                $query->phone_number = $data['phone_number'];
            if (isset($data['delivery']))
                $query->delivery = $data['delivery'];
            if (isset($data['map_location']))
                $query->map_location = $data['map_location'];
            if (isset($data['email_address']))
                $query->email_address = $data['email_address'];
            //save pharmacy
            $query->save();
            return $query;
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }

    }

    public function list(){

        try {
            return pharmacy::all();

        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }

    public function delete($id){

        try {
            return pharmacy::find($id)->delete();;

        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }
}
