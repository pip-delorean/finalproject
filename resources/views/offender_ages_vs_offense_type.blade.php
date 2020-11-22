@extends('layouts/layout')

@section('title', 'Offender Age VS Offense Type')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-end">
      <graph class="graph" xlabel="Age Group + Offense Type" ylabel="Number Of Offenses" type="bar" :keys="{{ json_encode(array_keys($data)) }}" :values="{{ json_encode(array_values($data)) }}"></graph>
    </div>
  </div>
@endsection
