@extends('layouts.app')
  
@section('content')
    <vue-table endpoint="{{route('api.server.list')}}" :columns="[
        { title: 'Type', field: 'gamemode', formatter: 'serverGamemode', headerSort: false, maxWidth: 70}, 
        { title: 'Server name', field: 'name', formatter: 'serverLink', width: '60%'}, 
        { title: 'Map name', field: 'variables-&gt;mapname', formatter: 'mapLink'},
        { title: 'Players', field: 'variables-&gt;numplayers', formatter: 'playerCell', maxWidth: 70},
      ]"
      id="serverList"></vue-table>
@endsection

@push('script-defs')

@endpush