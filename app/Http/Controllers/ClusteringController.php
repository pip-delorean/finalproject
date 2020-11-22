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
use Log;

class ClusteringController extends Controller
{
  public function offense_type_vs_weapon_type_dbscan(Request $request) {
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

  public function offense_type_vs_weapon_type_kmeans(Request $request) {
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

    $k_clusters = $ignore_unknown_weapon ? 17 : 37;
    $kmeans = new KMeans($k_clusters);
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

  public function offender_ages_vs_offense_type_dbscan(Request $request) {
    $ignore_unknown_age = $request->input('ignore_unknown_age') ?? true;
    set_time_limit(10000);

    if ($ignore_unknown_age === "false") {
      $ignore_unknown_age = false;
    } else {
      $ignore_unknown_age = true;
    }

    $offenses = Offense::select('OFFENSE_ID', 'INCIDENT_ID', 'OFFENSE_TYPE_ID')->with('incident', 'incident.offender', 'type')->get();
    $data = $offenses->map(function ($offense) use ($ignore_unknown_age) {
      $age = $offense->incident->offender->AGE_NUM ?? null;
      if ($age === 0) {
        $age = $ignore_unknown_age ? null : -1;
      }
      if ($age === null) {
        return null;
      }
      $age_range_id = array_keys($this->categorize_age($age))[0];
      $type_id = $offense->type->OFFENSE_TYPE_ID;
      return [$type_id, $age_range_id];
    });

    $samples = array_filter($data->toArray(), static function($value){return $value !== null;} );
    $dbscan = new DBSCAN($epsilon = 1, $minSamples = 50);
    $clusters = collect($dbscan->cluster($samples));

    foreach ($clusters as $cluster_id => $cluster) {
      $first_item = array_values($cluster)[0];
      $age_range_id = $first_item[1];
      $age_range_name = $this->age_range_labelize($age_range_id);
      $offense_name = OffenseType::find($first_item[0])->OFFENSE_NAME;
      $cluster_name = $age_range_name." + ".$offense_name;
      $clusters[$cluster_name] = sizeof($cluster);
      unset($clusters[$cluster_id]);
    }

    $data = $clusters->toArray();
    arsort($data);
    return view('offender_ages_vs_offense_type', compact("data", "ignore_unknown_age"));
  }

  public function offender_ages_vs_offense_type_kmeans(Request $request) {
    $ignore_unknown_age = $request->input('ignore_unknown_age') ?? true;
    set_time_limit(10000);

    if ($ignore_unknown_age === "false") {
      $ignore_unknown_age = false;
    } else {
      $ignore_unknown_age = true;
    }

    $offenses = Offense::select('OFFENSE_ID', 'INCIDENT_ID', 'OFFENSE_TYPE_ID')->with('incident', 'incident.offender', 'type')->get();
    $data = $offenses->map(function ($offense) use ($ignore_unknown_age) {
      $age = $offense->incident->offender->AGE_NUM ?? null;
      if ($age === 0) {
        $age = $ignore_unknown_age ? null : -1;
      }
      if ($age === null) {
        return null;
      }
      $age_range_id = array_keys($this->categorize_age($age))[0];
      $type_id = $offense->type->OFFENSE_TYPE_ID;
      return [$type_id, $age_range_id];
    });

    $samples = array_filter($data->toArray(), static function($value){return $value !== null;} );
    $k_clusters = $ignore_unknown_age ? 17 : 37;
    $kmeans = new KMeans($k_clusters);
    $clusters = collect($kmeans->cluster($samples));

    foreach ($clusters as $cluster_id => $cluster) {
      $first_item = array_values($cluster)[0];
      $age_range_id = $first_item[1];
      $age_range_name = $this->age_range_labelize($age_range_id);
      $offense_name = OffenseType::find($first_item[0])->OFFENSE_NAME;
      $cluster_name = $age_range_name." + ".$offense_name;
      $clusters[$cluster_name] = sizeof($cluster);
      unset($clusters[$cluster_id]);
    }

    $data = $clusters->toArray();
    arsort($data);
    return view('offender_ages_vs_offense_type', compact("data", "ignore_unknown_age"));
  }

  public function categorize_age($age) {
    if ($age === -1) {
      return [1 => "Unknown/Not Specified"];
    }
    if ($age > 0 && $age <= 12) {
      return [2 => "1-12"];
    }
    if ($age >= 13 && $age <= 19) {
      return [3 => "13-19"];
    }
    if ($age >= 20 && $age <= 30) {
      return [4 => "20-30"];
    }
    if ($age >= 31 && $age <= 40) {
      return [5 => "31-40"];
    }
    if ($age >= 41 && $age <= 60) {
      return [6 => "41-60"];
    }
    if ($age >= 61 && $age <= 80) {
      return [7 => "61-80"];
    }
    if ($age >= 81) {
      return [8 => "81+"];
    }
    return [1 => "Unknown/Not Specified"];
  }

  public function age_range_labelize($range_id) {
    $label_array = [
      1 => "Unknown/Not Specified",
      2 => "1-12",
      3 => "13-19",
      4 => "20-30",
      5 => "31-40",
      6 => "41-60",
      7 => "61-80",
      8 => "81+",
    ];
    return $label_array[$range_id];
  }
}
