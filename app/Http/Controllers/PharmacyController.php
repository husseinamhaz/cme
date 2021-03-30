<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PharmacyRequest;
use App\Pharmacy;
use App\Images;
use File;

class PharmacyController extends Controller
{


    /**
     * Store new Pharmacy
     */
    public function store(PharmacyRequest $request)
    {
        try {
            //get request data
            $data = $request->all();


            $query = new Pharmacy();
            if (isset($data['logo'])) {
                $logo=$data['logo'][0];
                $imagesFolder = public_path() . '/images/logos';
                $extension = $logo->getClientOriginalExtension();
                $filename = $data['name'] . '.jpg';
                $logo->move($imagesFolder, $filename);
                $query->logo = $filename;
            }
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

            if (isset($data['images'])) {
                $this->storeImages($query->id,$data['images']);
            }
            return $query->load('images');
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }

    }

    public function storeImages($id,$images){

        // Names of folders
        $imagesFolder = public_path() . '/images/' . $id;

        // loop through each image to save and upload
        foreach ($images as $image) {
            $extension = $image->getClientOriginalExtension();
            $filename = rand(100, 999999) . time() . '.' . $extension;
            $image->move($imagesFolder, $filename);

            // Passes filename to $inputData variable for database write
            $inputData['name'] = $filename;
            $inputData['pharmacy_id'] = $id;

            // writes to database
            Images::create($inputData);
        }
    }

    public function index()
    {

        try {
            return Pharmacy::with('images')->get();

        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }

    public function destroy($id)
    {

        try {
            $pharmacy=Pharmacy::find($id);
            if(File::exists(public_path() . '/images/logos/'.$pharmacy->name.'.jpg')) {
                File::delete(public_path() . '/images/logos/'.$pharmacy->name.'.jpg');
            }
            return $pharmacy->delete();;

        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }

    public function update(PharmacyRequest $request)
    {

        try {
            //get request data
            $data = $request->all();
            $pharmacy=Pharmacy::find($data['id']);
            if (isset($data['logo'])) {
                $logo=$data['logo'][0];
                $imagesFolder = public_path() . '/images/logos';
                $extension = $logo->getClientOriginalExtension();
                $filename = $data['name'] . '.' . $extension;
                $logo->move($imagesFolder, $filename);
                $pharmacy->logo = $filename;
            }
            if (isset($data['name']))
                $pharmacy->name = $data['name'];
            if (isset($data['phone_number']))
                $pharmacy->phone_number = $data['phone_number'];
            if (isset($data['delivery']))
                $pharmacy->delivery = $data['delivery'];
            if (isset($data['map_location']))
                $pharmacy->map_location = $data['map_location'];
            if (isset($data['email_address']))
                $pharmacy->email_address = $data['email_address'];
            $pharmacy->save();

            return $pharmacy->load('images');

        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }
}
