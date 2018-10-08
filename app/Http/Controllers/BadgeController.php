<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $preview = $request->get('preview');

        $messages = [];

        $messages['tagline'] = "<span>shipstreams.com</span> - " .  $request->get('tagline', 'where makers ship live');

        $messages['twitter'] = $request->get("twitter")
            ? "<span class='twitter-text'><i class='fa fa-twitter fa-lg'></i> Find me on Twitter:</span> " .  $request->get('twitter')
            : null;

        $messages['youtube'] = $request->get("youtube")
            ? "<span class='youtube-text'><i class='fa fa-youtube-play fa-lg'></i> Find me on YouTube:</span> " .  $request->get('youtube')
            : null;

        $messages['website'] = $request->get("website")
            ? "<span class='website-text'><i class='fa fa-globe fa-lg'></i> Visit my website:</span> " .  $request->get('website')
            : null;

        $messages['customMessage'] = $request->get('customMessage');

        return view(
            'badge.show',
            compact('messages', 'preview')
        );
    }

    public function generate()
    {
        return view(
            'badge.generate'
        );
    }
}
