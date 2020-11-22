<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offense;
use App\Models\Location;
use App\Models\Weapon;
use App\Models\WeaponType;
use App\Models\OffenseType;
use Phpml\Clustering\DBSCAN;


class ClusteringController extends Controller
{
  public function dbscan() {
    set_time_limit(10000);
    $offenses = Offense::select('OFFENSE_ID', 'OFFENSE_TYPE_ID')->with('type', 'weapon', 'weapon.type')->get();
    $unknown_weapon = Weapon::with('type')->find(19);
    $data = $offenses->map(function ($offense) use ($unknown_weapon) {
      if ($offense->weapon == null) {
        $offense->weapon = $unknown_weapon;
      }
      return [$offense->type->OFFENSE_TYPE_ID, $offense->weapon->type->WEAPON_ID];
    });
    $samples = $data->toArray();

    $dbscan = new DBSCAN($epsilon = 1, $minSamples = 50);
    $clusters = collect($dbscan->cluster($samples));

    $ignore_unknown_weapon = true;

    foreach ($clusters as $cluster_id => $cluster) {
      $offense_id = $cluster[0][0];
      $weapon_id = $cluster[0][1];
      if ($weapon_id == 19 && $ignore_unknown_weapon) {
        unset($clusters[$cluster_id]);
        continue;
      }
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
