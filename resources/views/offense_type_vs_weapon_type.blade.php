@extends('layouts/layout')

@section('title', 'Offense Type VS Weapon Type')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-end">
      <graph class="graph" xlabel="Offense Type + Weapon Type ({{ $ignore_unknown_weapon ? "Excluding" : "Including" }} Unknown Weapons)" ylabel="Number Of Offenses" type="bar" :keys="{{ json_encode(array_keys($data)) }}" :values="{{ json_encode(array_values($data)) }}"></graph>
    </div>
  </div>
@endsection
