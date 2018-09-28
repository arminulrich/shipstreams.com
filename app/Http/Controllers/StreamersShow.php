<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StreamersShow extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $slug)
    {
        $streamer = \App\Models\Streamer::whereTwitchUsername($slug)->first();
        abort_unless($streamer, 404);

        return view('streamers.show', compact('streamer'));
    }
}
