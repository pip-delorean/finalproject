<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Offense;
use App\Models\Location;
use App\Models\Weapon;

class ChartController extends Controller
{
  public function index() {
    return view('index');
  }
  public function incidents() {
    $incidents = Incident::all()->pluck('INCIDENT_ID', 'INCIDENT_DATE');
    return view('index', compact('incidents'));
  }

  public function offense_vs_location() {
    $offenses = Offense::select('LOCATION_ID', 'OFFENSE_ID')->with('location')->get();
    $data = [];
    foreach ($offenses as $offense) {
      $location_name = $offense->location->LOCATION_NAME;
      if (!array_key_exists($location_name, $data)) {
        $data[$location_name] = 0;
      };
      $data[$location_name] += 1;
    };
    arsort($data);
    return view('offense_vs_location', compact("data"));
  }

  public function offense_type_vs_weapon_type() {
    $offenses = Offense::select('OFFENSE_ID', 'OFFENSE_TYPE_ID')->with('type', 'weapon', 'weapon.type')->get();
    $unknown_weapon = Weapon::with('type')->find(19);
    $data = $offenses->map(function ($offense) use ($unknown_weapon) {
      if ($offense->weapon == null) {
        $offense->weapon = $unknown_weapon;
      }
      return [$offense->type->OFFENSE_NAME, $offense->weapon->type->WEAPON_NAME];
    });
    dd($data->first(), $data);
    $data = $data->toArray();
    return view('offense_type_vs_weapon_type', compact("data"));
  }
}
