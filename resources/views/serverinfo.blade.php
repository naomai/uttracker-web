@extends('layouts.app')
  
@section('content')
  <h2>{{ $server->name }}</h2>
    <vue-table endpoint="{{route('api.server.playerstats', $server->id)}}" :columns="[
        { title: 'Player', field: 'name', formatter: 'playerLink'}, 
        { title: 'Total score', field: 'score', headerSortStartingDir: 'desc'},
        { title: 'Game time', field: 'gameTime', formatter: (c)=>c.getData().gameTimeFormatted, headerSortStartingDir: 'desc'},
      ]"
      partial
      ></vue-table>
@endsection

@push('script-defs')

@endpush