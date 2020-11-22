<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $table = 'NIBRS_incident';
    protected $primaryKey = 'INCIDENT_ID';

    public function offender() {
      return $this->belongsTo('App\Models\Offender', 'INCIDENT_ID', 'INCIDENT_ID');
    }
}
