@extends('layouts.app')

@section('meta')
    @include('layouts.partials.meta')


    <title>{{$streamer->main_channel()->profile_name()}} - shipstreams.com</title>

    <meta name="description" content="{{$streamer->main_channel()->profile_name()}} is streaming now on Twitch">
    <meta name="og:description" content="{{$streamer->main_channel()->profile_name()}} is streaming now on Twitch">


    <!-- Facebook OG Image -->
    <meta property="og:image"
          content="https://placid.app/u/ktnsy?picture-0=$PIC${!! urlencode($streamer->main_channel()->profile_image_url()) !!}&text-0={!! urlencode($streamer->og_image_text) !!}"/>
    <meta property="og:image:height" content="600"/>
    <meta property="og:image:width" content="1200"/>

    <!-- Twitter Card Image -->
    <meta property="twitter:image"
          content="https://placid.app/u/ktnsy?picture-0=$PIC${!! urlencode($streamer->main_channel()->profile_image_url()) !!}&text-0={!! urlencode($streamer->og_image_text) !!}"/>
    <meta name="twitter:card" content="summary_large_image">

@endsection

@section('header')
    <h1 class="sr-only">{{$streamer->twitch_displayname}}</h1>
    <div class="container">
        <div class="header__headlines">
            <h1>shipstreams profile</h1>
            <p>{{$streamer->main_channel()->profile_name()}}</p>
        </div>
    </div>
@endsection

@section('content')

    @php
        $showStreamPanel = ($streamer->is_online  || $streamer->twitch_username);
    @endphp

    <div class="detail @if($showStreamPanel) detail--with-stream @endif ">
        <div class="container">
            <div class="detail__stream">

                @if($showStreamPanel)
                    <div class="twitch-panel__wrap">
                        <twitch-panel :streamers='@json([$streamer])'></twitch-panel>
                    </div>
                @endif

            </div>
        </div>
        <div class="detail__body">

            <div class="container  ">
                <div class="row">
                    <div class="col-12 col-lg-8 mb-5 mb-lg-0">

                        <h2 class="detail__body-head">
                            About
                        </h2>

                        {{$streamer->main_channel()->profile_description()}}

                    </div>
                    <div class="col-12 col-lg-4 ">

                        <h2 class="detail__body-head">
                            Links
                        </h2>
                        @if($streamer->is_online)
                            <a class="font-weight-bold text-danger" target="_blank"
                               href="{{$streamer->tweet_twitch_live_url}}">
                                <i class="fab fa-twitter"></i>
                                Tweet about this stream</a>
                        @endif
                        <br>
                        @if($streamer->twitch_username)
                            <a class="font-weight-bold" href="{{$streamer->twitch()->channel_url()}}" target="_blank">
                                <i class="fab fa-twitch"></i>
                                Watch it on Twitch</a>
                        @endif
                        @if($streamer->youtube_channel_id)
                            <br>

                            <a class="font-weight-bold"
                               href="https://youtube.com/channel/{{$streamer->youtube_channel_id}}"
                               target="_blank">
                                <i class="fab fa-youtube"></i>
                                Watch it on Youtube</a>
                        @endif
                        @if($streamer->twitter)
                            <br>
                            <a class="font-weight-bold" href="https://twitter.com/{{$streamer->twitter}}"
                               target="_blank">
                                <i class="fab fa-twitter"></i>
                                Follow {{$streamer->twitter}} on Twitter</a>
                        @endif
                        @if($streamer->website)
                            <br>
                            <a class="font-weight-bold" href="{{$streamer->website}}" target="_blank">
                                <i class="fas fa-link"></i>
                                {{basename($streamer->website)}}</a>
                        @endif
                    </div>
                </div>


            </div>

        </div>

        <div class="detail__teaser">
            <div class="container">
                <div class="detail__teaser-illustration">
                    <svg width="383px" height="153px" viewBox="0 0 383 153" version="1.1"
                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Desktop-HD-Copy-2" transform="translate(-166.000000, -1490.000000)" fill="#5596FF"
                               fill-rule="nonzero">
                                <g id="Teaser" transform="translate(0.000000, 1428.000000)">
                                    <g id="noun_waves_126322_000000" transform="translate(166.000000, 62.000000)">
                                        <path d="M81.9683973,153 L0,153 C67.1015801,113.50303 94.8261851,20 140.230248,20 C160.320542,20 175.187359,32.4939394 178,47.0030303 C153.891648,34.9121212 131.792325,56.2727273 131.792325,83.2757576 C131.792325,92.5454545 133.801354,101.412121 137.819413,109.472727 C124.559819,123.578788 110.094808,136.072727 93.6207675,145.745455 L81.9683973,153 Z M383,153 C353.8,141.296429 333.8,121.117857 333.8,94.0785714 C333.8,71.075 352.2,52.9142857 372.6,63.0035714 C370.2,50.4928571 357.4,40 341,40 C302.2,40 279.4,119.503571 223,153 L383,153 Z M219.881092,146.557895 C235.465887,137.297368 248.653021,124.010526 260.241715,109.918421 C253.448343,99.0473684 249.851852,86.9684211 249.851852,73.2789474 C249.851852,41.8736842 275.426901,17.7157895 303,31.4052632 C299.803119,14.4947368 282.220273,0 259.442495,0 C206.693957,0 175.124756,107.905263 98,153 L208.692008,153 L219.881092,146.557895 Z"
                                              id="Shape"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>

                </div>
                <div class="detail__teaser-cta">
                    <div>
                        <h4>A list of makers shipping live.</h4>
                        <a href="/" class="btn btn-danger text-uppercase font-weight-bold">See all makers</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection