<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>shipstreams.com</title>


    <meta name="description" content="A list of People shipping live">
    <meta name="og:description" content="A list of People shipping live">
    
    <!-- Facebook OG Image -->
    <meta property="og:image" content="https://placid.app/u/cxhrd?glow=%24DEFAULT%24&title=%24DEFAULT%24&logo=%24DEFAULT%24"/>
    <meta property="og:image:height" content="600"/>
    <meta property="og:image:width" content="1200"/>

    <!-- Twitter Card Image -->
    <meta property="twitter:image" content="https://placid.app/u/cxhrd?glow=%24DEFAULT%24&title=%24DEFAULT%24&logo=%24DEFAULT%24"/>
    <meta name="twitter:card" content="summary_large_image">


    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet" type="text/css">
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
          integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
<div id="app">
    <div class="mt-5 mb-4 ">
        <?PHP
        $online = $streamers->sortBy(function ($streamer) {
            /** @var \App\Streamer $streamer */
            return $streamer->username;
        })->groupBy(function ($streamer) {
            /** @var \App\Streamer $streamer */
            if ($streamer->has_active_stream()) {
                return 'online';
            }
            return 'offline';
        });

        ?>

        <div class="container">
            <h1 class="text-center mb-3 font-weight-bold">🚢 shipstreams.com</h1>
            <p class="font-weight-bold text-center mb-5">A list of People shipping live.
            <small class="text-muted">(from <a href="https://wip.chat" target="_blank">🚧 wip.chat</a>)</small>
            </p>

            @if($online->get('online',collect())->count())
                <h2 class=" mb-4 text-center">
                    <span class="text-danger ml-3 font-weight-bold">
                        <i class="fas fa-circle blink"></i> LIVE
                    </span>
                </h2>
                @include('partials.streamer-list',['streamers'=>$online->get('online'),'isStreaming'=>true])
            @endif
            @if($online->get('offline',collect())->count())
                <h2 class="mb-4 text-center">Offline</h2>
                @include('partials.streamer-list',['streamers'=>$online->get('offline')])
            @endif
        </div>
    </div>
    @include('partials.made-by')

</div>
<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
