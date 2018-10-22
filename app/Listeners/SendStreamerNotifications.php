<?php
namespace App\Listeners;

use App\Events\StreamerWentOnline;
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
    public function handle(StreamerWentOnline $event)
    {
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

    private function sendTelegram(StreamerWentOnline $event)
    {
        $apiToken = env('TELEGRAM_API_TOKEN');
        if (!$apiToken) {
            return;
        }

        $channel = "@shipstreams";
        $text = $event->streamer->main_channel()->telegram_live_text();

        $data = ['chat_id' => $channel, 'text' => $text];

        if (app()->environment() != "production") {
            print_r('TELEGRAM POSTED: ' . print_r($data, true));
        } else {
            file_get_contents(
                "https://api.telegram.org/bot$apiToken/sendMessage?" .
                    http_build_query($data)
            );
        }
    }

    private function sendBuffer(StreamerWentOnline $event)
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
        $update->text = $event->streamer->main_channel()->tweet_live_text();
        $update->shorten = 'false';
        $update->now = 'true';
        $update->top = 'true';
        //$update->schedule((new Carbon())->setTime(21, 0, 0)->addDay()); // you can use timestamp

        if (app()->environment() != "production") {
            print_r(
                'TWITTER POSTED: ' .
                    print_r(
                        $event->streamer->main_channel()->tweet_live_text(),
                        true
                    )
            );
        } else {
            $client->createUpdate($update);
        }
    }
}
