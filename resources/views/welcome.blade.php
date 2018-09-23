<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>🚢 shipstreams.com</title>

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
            <p class="font-weight-bold text-center mb-5">A list of People shipping live  (from <a href="https://wip.chat" target="_blank">🚧 wip.chat</a>)</p>

            @if($online->get('online',collect())->count())
                <h2 class="mb-4 text-center">Streaming</h2>
                @include('partials.streamer-list',['streamers'=>$online->get('online')])
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
