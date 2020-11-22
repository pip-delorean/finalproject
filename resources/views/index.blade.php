@extends('layouts/layout')

@section('title', 'Home')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-center flex-direction-column">
      <h1>Nebraska 2018 FBI Crime Statistics</h1>
      <h2>Choose a visualization/analysis (Most should run in a minute or less):</h2>
      <ul>
        <li><a href="/offense_vs_location">Offense VS Location</a></li>
        <li><a href="/offense_type_vs_weapon_type_dbscan">Offense Type VS Weapon Type (DBSCAN), </a></li>
        <li><a href="/offense_type_vs_weapon_type_dbscan?ignore_unknown_weapon=false">Offense Type VS Weapon Type (DBSCAN, Including Unknown Weapons)</a><b>, Will take ~15 minutes</b></li>
        <li><a href="/offense_type_vs_weapon_type_kmeans">Offense Type VS Weapon Type (KMeans)</a></li>
        <li><a href="/offense_type_vs_weapon_type_kmeans?ignore_unknown_weapon=false">Offense Type VS Weapon Type (KMeans, Including Unknown Weapons)</a></li>
        <li><a href="/offender_ages_vs_offense_type_dbscan">Offenders By Age VS Offense Type (DBSCAN)</a></li>
        <li><a href="/offender_ages_vs_offense_type_dbscan?ignore_unknown_age=false">Offenders By Age VS Offense Type (DBSCAN, Including Unknown Age)</a><b>, Will take ~15 minutes</b></li>
        <li><a href="/offender_ages_vs_offense_type_kmeans">Offenders By Age VS Offense Type (KMeans)</a></li>
        <li><a href="/offender_ages_vs_offense_type_kmeans?ignore_unknown_age=false">Offenders By Age VS Offense Type (KMeans, Including Unknown Age)</a></li>
        <li><a href="/offender_ages">Offenders By Age</a></li>
        <li><a href="/offender_ages?ignore_unknown_age=false">Offenders By Age (Including Unknown Age)</a></li>
      </ul>
    </div>
  </div>
@endsection
