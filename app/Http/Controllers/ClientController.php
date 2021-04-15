<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
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
    public function storeCompanyClientRelation(ClientRequest $request)
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
             // $data = json_decode(Http::get('https://ah-devsec.com/test/'));
            // because http:get has curl error in my laptop i set the data staticly
            $data=[["name"=>"haysen","email"=>"haysen@outlook.com"],["name"=>"lara","email"=>"lara@gmail.com"]];
             $matchThese=[];
             $where='';
             $query = Clients::query();
             foreach ($data as $key => $value) {
                $query = $query->orwhere('name', $value['name'])->where('email',$value['email']);
             }
             return $query->get();
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage(),
                'error' => $e->getCode(),
            ];
        }
    }
}
