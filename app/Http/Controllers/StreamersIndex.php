<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StreamersIndex extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $streamers = \App\Models\Streamer
            ::where('twitch_user_id', '>', 0)
            ->orderBy('last_online', 'DESC')
            ->orderBy('twitch_username', 'ASC')
            ->get();

        $streamers_online = $streamers->where('is_online', true)->shuffle();

        return view(
            'streamers.index',
            compact('streamers', 'streamers_online')
        );
    }
}
