@extends('layouts.app')

@section('header')

    <div class="container">
        <div class="header__headlines">
            <h1>shipstreams</h1>
            <p> A list of makers <br> shipping live. </p>
        </div>
    </div>

@endsection
@section('content')

    @include('streamers.partials.list',['streamers'=>$streamers])

    <div class="row mt-5">
        <div class="col-12 font-weight-bold">
            Send me you Profile <a href="{{route('submit')}}" >here</a> ! 🚢
        </div>
    </div>

@endsection