<?php
namespace App\Console\Commands;

use App\Events\StreamerWentOnline;
use App\Models\Streamer;
use Illuminate\Console\Command;
use Psy\Util\Str;
use romanzipp\Twitch\Twitch;

class RefreshStreamersOnlineState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:streamers_online';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh only online states';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var Twitch $twitch */
        $twitch = app(Twitch::class);

        $twitchUserids = $allTwitchStreamers = Streamer
            ::all()
            ->pluck('twitch_user_id');

        $twitch_data_streams = collect(
            $twitch->getStreamsByUserIds($twitchUserids->toArray())->data
        )->groupBy('user_id');

        foreach ($twitch_data_streams as $user_id => $streams) {
            $streamer = Streamer::where('twitch_user_id', $user_id)->first();
            if ($streamer) {
                $streamer->twitch_stream = $streams->first();
                $streamer->is_online = true;
                $streamer->save();
            }
        }
        // refresh youtube
        // add YT data
        $ytStreamers = Streamer::whereNotNull('youtube_channel_id')->get();
        foreach ($ytStreamers as $streamer) {
            $url = "https://www.googleapis.com/youtube/v3/search";

            $client = new \GuzzleHttp\Client();
            $response = $client->get($url, [
                'query' =>
                    [
                        'key' => env('YOUTUBE_API_KEY'),
                        'channelId' => $streamer->youtube_channel_id,
                        'eventType' => 'live',
                        'type' => 'video',
                        'part' => 'snippet'
                    ]
            ]);
            $json = json_decode($response->getBody()->getContents(), true);
            $streamer->youtube_stream = (array) data_get($json, 'items.0');
            $streamer->is_online = true;

            $streamer->save();
        }
    }
}
