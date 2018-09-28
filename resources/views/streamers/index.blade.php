@extends('layouts.app')

@section('header')

    <div class="container">
        <div class="header__headlines">
            <h1>shipstreams</h1>
            <p> A list of makers <br> shipping live. </p>
        </div>
    </div>

@endsection
<?PHP
        /** @var \Illuminate\Support\Collection $streamers_online */
?>
@section('content')

    @if($streamers_online->count())
        <div class="twitch-panel__wrap">
            <twitch-panel :streamers='@json($streamers_online)' ></twitch-panel>    
        </div>
    @endif

    @include('streamers.partials.list',['streamers'=>$streamers])

    <div class="row mt-5">
        <div class="col-12 font-weight-bold">
            Send me you Profile <a href="{{route('submit')}}">here</a> ! 🚢
        </div>
    </div>

@endsection