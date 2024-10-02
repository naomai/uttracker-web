@extends('layouts.app')
  
@section('content')
    <vue-table endpoint="{{route('api.server.list')}}" :columns="[
        { title: 'Server name', field: 'name', formatter: 'serverLink'}, 
        { title: 'Map name', field: 'variables.mapname', formatter: 'mapLink'},
      ]"></vue-table>
@endsection

@push('script-defs')

@endpush