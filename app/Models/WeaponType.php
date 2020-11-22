<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    use HasFactory;

    protected $table = 'NIBRS_WEAPON_TYPE';
    protected $primaryKey = 'WEAPON_ID';
}
