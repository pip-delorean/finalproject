@extends('layouts/layout')

@section('title', 'Home')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-end">
      <graph class="graph" :keys={{ json_encode(array_keys($incidents->toArray())) }} :values={{ json_encode(array_values($incidents->toArray())) }}></graph>
    </div>
  </div>
@endsection
