<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $table = 'NIBRS_LOCATION_TYPE';
    protected $primaryKey = 'LOCATION_ID';
}
