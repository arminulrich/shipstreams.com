<?php
Route::get('/', function () {
    $streamers = collect();
    $streamers->push(new \App\Streamer('getaclue_1'));
    $streamers->push(new \App\Streamer('patwalls'));
    $streamers->push(new \App\Streamer('pugs0n'));
    $streamers->push(new \App\Streamer('arminulrich'));
    $streamers->push(new \App\Streamer('pretzelhands'));
    //$streamers->push(new \App\Streamer('levelsio'));
    //$streamers->push(new \App\Streamer('andrey_azimov'));
    //$streamers->push(new \App\Streamer('h0h0h0'));
    //$streamers->push(new \App\Streamer('lenilsonjr_'));
    //$streamers->push(new \App\Streamer('swizec'));

    return view('welcome', compact('streamers'));
});
