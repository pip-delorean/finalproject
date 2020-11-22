@extends('layouts/layout')

@section('title', 'Offense VS Location')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-end">
      <graph class="graph" xlabel="Location" ylabel="Number Of Offenses" type="bar" :keys="{{ json_encode(array_keys($data)) }}" :values="{{ json_encode(array_values($data)) }}"></graph>
    </div>
  </div>
@endsection
