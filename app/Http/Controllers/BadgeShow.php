<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BadgeShow extends Controller
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
        $tagline = $request->get('tagline', 'where makers ship live');

        return view('badge.show', compact('tagline'));
    }
}
