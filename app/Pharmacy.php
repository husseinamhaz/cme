<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $table = 'pharmacy';
    protected $fillable = ["name", "phone_number", "delivery", "map_location", "email_address"];

    public function images()
    {
        return $this->hasMany('App\Images');
    }
}
