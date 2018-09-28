@extends('layouts.app')

@section('meta')
    @include('layouts.partials.meta')


    <title>{{$streamer->twitch_displayname}} - shipstreams.com</title>

    <meta name="description" content="{{$streamer->twitch_displayname}} is streaming now on Twitch">
    <meta name="og:description" content="{{$streamer->twitch_displayname}} is streaming now on Twitch">


    <!-- Facebook OG Image -->
    <meta property="og:image" content="https://placid.app/u/5eh6m?title={!! urlencode($streamer->og_image_text) !!}"/>
    <meta property="og:image:height" content="600"/>
    <meta property="og:image:width" content="1200"/>

    <!-- Twitter Card Image -->
    <meta property="twitter:image" content="https://placid.app/u/5eh6m?title={!! urlencode($streamer->og_image_text) !!}"/>
    <meta name="twitter:card" content="summary_large_image">
    
@endsection

@section('header')
    <h1 class="sr-only">{{$streamer->twitch_displayname}}</h1>
@endsection

@section('content')

    <div class="twitch-panel__wrap">
        <twitch-panel :streamers='@json([$streamer])'></twitch-panel>
    </div>

    @if($streamer->is_online)
        <a class="font-weight-bold text-danger" target="_blank" href="{{$streamer->tweet_twitch_live_url}}">
            <i class="fab fa-twitter"></i>
            Tweet about this stream</a>
    @endif        
    <br>
    <a class="font-weight-bold" href="{{$streamer->twitch_url}}" target="_blank">
        <i class="fab fa-twitch"></i>
        Watch it on Twitch</a>
    @if($streamer->twitter)
        <br>
        <a class="font-weight-bold" href="https://twitter.com/{{$streamer->twitter}}" target="_blank">
            <i class="fab fa-twitter"></i>
            Follow {{$streamer->twitter}} on Twitter</a>
    @endif
    @if($streamer->website)
        <br>
        <a class="font-weight-bold" href="{{$streamer->website}}" target="_blank">
            <i class="fas fa-link"></i>
            {{basename($streamer->website)}}</a>
    @endif
@endsection