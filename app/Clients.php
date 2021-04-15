<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $table = 'clients';
    protected $fillable = ["name", "email"];
    public $timestamps = false;



    public function clientsRelation()
    {
        return $this->hasOne("App\CompaniesClientsR", "client_id", "id")
            ->with('clients');
    }
}
