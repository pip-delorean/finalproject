@extends('layouts/layout')

@section('title', 'Offender by Age')

@section('content')
  <div id="root">
    <div class="flex flex-justify-center flex-align-end">
      <pie class="graph" title="Offenders By Age (Years)" :isdoughnut="true" :keys="{{ json_encode(array_keys($data)) }}" :values="{{ json_encode(array_values($data)) }}"></pie>
    </div>
  </div>
@endsection
