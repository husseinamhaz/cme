<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pharmacy extends Model
{
    protected $table = 'pharmacy';
    protected $fillable = ["name", "phone_number", "delivery", "map_location", "email_address"];
}
