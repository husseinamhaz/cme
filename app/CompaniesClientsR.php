<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompaniesClientsR extends Model
{
    protected $table = 'companies_clients_r';
    protected $fillable = ["client_id", "company_id"];
    public $timestamps = false;


    public function clients()
    {
        return $this->hasOne("App\Clients", "id", "client_id");
    }


    public function companies()
    {
        return $this->hasOne("App\Companies", "id", "company_id");
    }

}
