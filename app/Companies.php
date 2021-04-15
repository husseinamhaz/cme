<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $table = 'companies';
    protected $primaryKey='id';
    protected $fillable = ['company_name'];
    public $timestamps = false;

    public function companyRelation()
    {
        return $this->hasOne("App\CompaniesClientsR", "company_id", "id")
            ->with('companies');
    }
}
