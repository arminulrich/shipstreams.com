@extends('layouts.app')

@section('content')

    @include('streamers.partials.list',['streamers'=>$streamers])
    
@endsection