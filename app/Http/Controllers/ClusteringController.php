<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offense;
use App\Models\Location;
use App\Models\Weapon;
use App\Models\WeaponType;
use App\Models\OffenseType;
use Phpml\Clustering\DBSCAN;
use Phpml\Clustering\KMeans;

class ClusteringController extends Controller
{
  public function dbscan(Request $request) {
    $ignore_unknown_weapon = $request->input('ignore_unknown_weapon') ?? true;
    set_time_limit(10000);

    if ($ignore_unknown_weapon === "false") {
      $ignore_unknown_weapon = false;
    } else {
      $ignore_unknown_weapon = true;
    }

    $offenses = Offense::select('OFFENSE_ID', 'OFFENSE_TYPE_ID')->with('type', 'weapon', 'weapon.type')->get();
    $unknown_weapon = Weapon::with('type')->find(19);
    $data = $offenses->map(function ($offense) use ($unknown_weapon, $ignore_unknown_weapon) {
      if ($offense->weapon == null) {
        $offense->weapon = $unknown_weapon;
      }
      if ($ignore_unknown_weapon && $offense->weapon->type->WEAPON_ID == 19) {
        return null;
      }
      return [$offense->type->OFFENSE_TYPE_ID, $offense->weapon->type->WEAPON_ID];
    });

    $samples = array_filter($data->toArray(), static function($value){return $value !== null;} );

    $dbscan = new DBSCAN($epsilon = 1, $minSamples = 50);
    $clusters = collect($dbscan->cluster($samples));

    foreach ($clusters as $cluster_id => $cluster) {
      $offense_id = $cluster[0][0];
      $weapon_id = $cluster[0][1];
      $offense_name = OffenseType::find($offense_id)->OFFENSE_NAME;
      $weapon_name = WeaponType::find($weapon_id)->WEAPON_NAME;
      $cluster_name = $offense_name." + ".$weapon_name;
      $clusters[$cluster_name] = sizeof($cluster);
      unset($clusters[$cluster_id]);
    }
    $data = $clusters->toArray();
    arsort($data);
    return view('offense_type_vs_weapon_type', compact("data", "ignore_unknown_weapon"));
  }

  public function kmeans(Request $request) {
    $ignore_unknown_weapon = $request->input('ignore_unknown_weapon') ?? true;
    set_time_limit(10000);

    if ($ignore_unknown_weapon === "false") {
      $ignore_unknown_weapon = false;
    } else {
      $ignore_unknown_weapon = true;
    }

    $offenses = Offense::select('OFFENSE_ID', 'OFFENSE_TYPE_ID')->with('type', 'weapon', 'weapon.type')->get();
    $unknown_weapon = Weapon::with('type')->find(19);
    $data = $offenses->map(function ($offense) use ($unknown_weapon, $ignore_unknown_weapon) {
      if ($offense->weapon == null) {
        $offense->weapon = $unknown_weapon;
      }
      if ($ignore_unknown_weapon && $offense->weapon->type->WEAPON_ID == 19) {
        return null;
      }
      return [$offense->type->OFFENSE_TYPE_ID, $offense->weapon->type->WEAPON_ID];
    });

    $samples = array_filter($data->toArray(), static function($value){return $value !== null;} );

    $kmeans = new KMeans(17);
    $clusters = collect($kmeans->cluster($samples));

    foreach ($clusters as $cluster_id => $cluster) {
      $first_item = array_values($cluster)[0];
      $offense_id = $first_item[0];
      $weapon_id = $first_item[1];
      $offense_name = OffenseType::find($offense_id)->OFFENSE_NAME;
      $weapon_name = WeaponType::find($weapon_id)->WEAPON_NAME;
      $cluster_name = $offense_name." + ".$weapon_name;
      $clusters[$cluster_name] = sizeof($cluster);
      unset($clusters[$cluster_id]);
    }
    $data = $clusters->toArray();
    arsort($data);
    return view('offense_type_vs_weapon_type', compact("data", "ignore_unknown_weapon"));
  }
}
