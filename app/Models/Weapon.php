<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $table = 'NIBRS_WEAPON';
    protected $primaryKey = 'WEAPON_ID';

    function type() {
      return $this->belongsTo('App\Models\WeaponType', 'WEAPON_ID', 'WEAPON_ID');
    }
}
