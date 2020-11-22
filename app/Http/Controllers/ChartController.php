<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incident;
use App\Models\Offense;
use App\Models\Location;
use App\Models\Weapon;
use App\Models\Offender;

class ChartController extends Controller
{
  public function index() {
    return view('index');
  }

  public function offender_ages() {
    set_time_limit(10000);
    $offenses = Offense::select('OFFENSE_ID', 'INCIDENT_ID')->with('incident', 'incident.offender')->get();
    $data = [
      "Unknown/Not Specified" => 0,
      "0-12" => 0,
      "13-19" => 0,
      "20-30" => 0,
      "31-40" => 0,
      "41-60" => 0,
      "61-80" => 0,
      "81+" => 0,
    ];

    foreach ($offenses as $offense) {
      $age = $offense->incident->offender->AGE_NUM ?? null;
      if ($age == null) {
        $data["Unknown/Not Specified"] += 1;
        continue;
      }
      if ($age >= 0 && $age <= 12) {
        $data["0-12"] += 1;
        continue;
      }
      if ($age >= 13 && $age <= 19) {
        $data["13-19"] += 1;
        continue;
      }
      if ($age >= 20 && $age <= 30) {
        $data["20-30"] += 1;
        continue;
      }
      if ($age >= 31 && $age <= 40) {
        $data["31-40"] += 1;
        continue;
      }
      if ($age >= 41 && $age <= 60) {
        $data["41-60"] += 1;
        continue;
      }
      if ($age >= 61 && $age <= 80) {
        $data["61-80"] += 1;
        continue;
      }
      if ($age >= 81) {
        $data["81+"] += 1;
        continue;
      }
    };
    return view('offender_ages', compact('data'));
  }

  public function offense_vs_location() {
    set_time_limit(10000);
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
}
