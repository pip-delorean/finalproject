<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffenseType extends Model
{
    use HasFactory;

    protected $table = 'NIBRS_OFFENSE_TYPE';
    protected $primaryKey = 'OFFENSE_TYPE_ID';
}
