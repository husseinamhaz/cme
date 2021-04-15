<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PharmacyRequest;
use App\Http\Requests\SearchPharmacyRequest;
use App\Clients;
use App\Companies;
use App\CompaniesClientsR;
use Illuminate\Support\Facades\Http;

class ClientController extends Controller
{


    /**
     * Store new Client
     */
    public function storeClient($data)
    {
        try {
            //get request data
            // $data = $request->all();
            $query = new Clients();
            if (isset($data['client_name']))
                $query->name = $data['client_name'];
            if (isset($data['email']))
                $query->email = $data['email'];
            //save Client
             $query->save();
             return $query;
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }

    }

    /**
     * Store new Company
     */
    public function storeCompany($data)
    {
        try {
            //get request data
            // $data = $request->all();
            $query = new Companies();
            if (isset($data['company_name']))
                $query->company_name = $data['company_name'];
            //save Company
            $query->save();
            return $query;
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }

    }

    /**
     * Store new Client and Company
     */
    public function storeCompanyClientRelation(PharmacyRequest $request)
    {
        try {
            $data = $request->all();
            $client=$this->storeClient($data);
            if (isset($client['error'])) {
            return $client['error'];
        }
            $company=$this->storeCompany($data);
            if (isset($company['error'])) {
            return $company['error'];
        }
            $query = new CompaniesClientsR();
            if (isset($client->id))
                $query->client_id = $client->id;
            if (isset($company->id))
                $query->company_id = $company->id;
            //save relation
            $query->save();
            return [
                'client_name'=>$client->name,
                'company_name'=>$company->company_name,
                 'email'=>$client->email
            ];
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }

    }

    /**
     * list Clients and Companies
     */
    public function index()
    {

        try {
            return CompaniesClientsR::with('clients')->with('companies')->get();

        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }


    /**
     * list Clients and Companies
     */
    public function getMatches()
    {

        try {
             $data = json_decode(Http::get('https://ah-devsec.com/test/'));
             $matchThese=[];
             $where='';
             foreach ($data as $key => $value) {
                array_push($matchThese, ['name'=>$value->name,'email'=>$value->email]);
                // $where='name='$value->name.'AND email='.$value->email.' AND '.$where;
             }
             return $matchThese;

            return Clients::where($matchThese)->get();
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }
}
