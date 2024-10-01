@extends('layouts.app')
  
@section('content')
    <vue-table :endpoint="{{route('api.servers')}}" :columns="[
        { title: 'Server name', field: 'name', headerFilter:'input'}, 
        { title: 'Map name', field: 'mapname', headerFilter:'input'}, 
      ]"></vue-table>
@endsection