<?php
namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ipalaus\Buffer\Client;
use Ipalaus\Buffer\TokenAuthorization;
use Ipalaus\Buffer\Update;

class SendStreamerNotifications
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (app()->environment() != "production") {
            return;
        }
        // - silent fail until i know what happened
        try {
            $this->sendTelegram($event);
        } catch (\Exception $e) {

        }
        try {
            $this->sendBuffer($event);
        } catch (\Exception $e) {

        }
    }

    private function sendTelegram($event)
    {
        $apiToken = env('TELEGRAM_API_TOKEN');
        if (!$apiToken) {
            return;
        }

        $channel = "@shipstreams";

        $text = $event->streamer->telegram_twitch_live_text;

        $data = ['chat_id' => $channel, 'text' => $text];

        file_get_contents(
            "https://api.telegram.org/bot$apiToken/sendMessage?" .
                http_build_query($data)
        );
    }

    private function sendBuffer($event)
    {
        // using my buffer account because no twitter dev account; and didnt want to go the auth route lol
        $bufferProfileId = env('BUFFER_PROFILE_ID');
        $bufferAuthToken = env('BUFFER_AUTHTOKEN');
        if (!$bufferProfileId || !$bufferAuthToken) {
            return;
        }

        $auth = new TokenAuthorization(env('BUFFER_AUTHTOKEN'));
        $client = new Client($auth);

        $update = new Update();
        $update->addProfile($bufferProfileId);
        $update->text = $event->streamer->tweet_twitch_live_text;
        $update->shorten = 'false';
        $update->now = 'true';
        $update->top = 'true';
        //$update->schedule((new Carbon())->setTime(21, 0, 0)->addDay()); // you can use timestamp
        $client->createUpdate($update);
    }
}
