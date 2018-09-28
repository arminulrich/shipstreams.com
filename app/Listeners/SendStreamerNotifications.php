<?php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $apiToken = env('TELEGRAM_API_TOKEN');
        if (!$apiToken) {
            return;
        }

        $channel = "@shipstreams";
        $list = collect([
            '📹 ' .
                $event->streamer->twitch_displayname .
                ' is live streaming now',
            "",
            '👇' . "\n" . $event->streamer->shipstreams_url
        ]);

        $text = $list->implode("\n");

        $data = ['chat_id' => $channel, 'text' => $text];

        file_get_contents(
            "https://api.telegram.org/bot$apiToken/sendMessage?" .
                http_build_query($data)
        );
    }
}
