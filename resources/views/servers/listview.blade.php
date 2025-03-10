@extends('layouts.app')
  
@section('content')
    <server-browser api-url="{{route('api.server.list')}}" ></server-browser>
@endsection

@push('script-defs')

@endpush