@extends('layouts/layout')

@section('title', 'Home')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-end">
      <ul>
        <li><a href="/offense_vs_location">Offense VS Location</a></li>
        <li><a href="/offense_type_vs_weapon_type">Offense VS Weapon Type</a></li>
        <li><a href="/incidents">Incidents</a></li>
        <li><a href="/dbscan">DBSCAN</a></li>
      </ul>
    </div>
  </div>
@endsection
