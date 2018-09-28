<?php
namespace App\Http\Controllers;

use App\Http\Requests\SubmitProfileRequest;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmitController extends Controller
{
    public function show()
    {
        return view('submit.show');
    }

    public function store(SubmitProfileRequest $request)
    {
        $submission = new Submission();
        $submission->data = $request->only([
            'email',
            'twitch_username',
            'twitter_handle',
            'website'
        ]);
        $submission->save();
        return redirect()->route('submit', ['success' => true]);
    }
}
