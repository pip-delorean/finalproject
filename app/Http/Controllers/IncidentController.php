<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;

class IncidentController extends Controller
{
  public function show() {
    $incidents = Incident::all()->pluck('INCIDENT_ID', 'INCIDENT_DATE');
    return view('index', compact('incidents'));
  }
}
