@extends('layouts.app')
  
@section('content')
    <vue-table endpoint="{{route('api.server.list')}}" :columns="[
        { title: 'Server name', field: 'name', formatter: 'serverLink'}, 
        { title: 'Map name', field: 'variables-&gt;mapname', formatter: 'mapLink'},
        { title: 'Players', field: 'variables-&gt;numplayers', formatter: 'playerCell'},
      ]"></vue-table>
@endsection

@push('script-defs')

@endpush