@extends('layouts/layout')

@section('title', 'Home')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-end">
      <ul>
        <li><a href="/offense_vs_location">Offense VS Location</a></li>
        <li><a href="/offense_type_vs_weapon_type_dbscan">Offense Type VS Weapon Type (DBSCAN), </a><b>Will take ~15 minutes (~46,000 data points)</b></li>
        <li><a href="/offense_type_vs_weapon_type_kmeans">Offense Type VS Weapon Type (KMeans), </a><b>Will take ~15 minutes (~46,000 data points)</b></li>
        <li><a href="/offender_ages">Offenders By Age</a></li>
      </ul>
    </div>
  </div>
@endsection
