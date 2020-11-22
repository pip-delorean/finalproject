<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offense extends Model
{
    use HasFactory;

    protected $table = 'NIBRS_OFFENSE';
    protected $primaryKey = 'OFFENSE_ID';

    function type() {
      return $this->belongsTo('App\Models\OffenseType', 'OFFENSE_TYPE_ID', 'OFFENSE_TYPE_ID');
    }

    function weapon() {
      return $this->belongsTo('App\Models\Weapon', 'OFFENSE_ID', 'OFFENSE_ID');
    }

    function location() {
      return $this->belongsTo('App\Models\Location', 'LOCATION_ID', 'LOCATION_ID');
    }
}
