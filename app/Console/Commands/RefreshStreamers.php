<?php
namespace App\Console\Commands;

use App\Models\Streamer;
use Guzzle\Http\Client;
use Illuminate\Console\Command;
use League\Csv\Stream;
use romanzipp\Twitch\Twitch;

class RefreshStreamers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:streamers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh data from twitch';

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

        // - twitch user ids
        $twitchUserids = $allTwitchStreamers = Streamer
            ::all()
            ->pluck('twitch_user_id');

        // - fetch all data
        $twitchUsers = [];

        // get user data
        $twitch_user_data = collect(
            $twitch->getUsersByIds($twitchUserids->toArray())->data
        );

        foreach ($twitch_user_data as $twitch_user) {
            $streamer = Streamer
                ::whereTwitchUserId(data_get($twitch_user, 'id'))
                ->first();
            if ($streamer) {
                $streamer->twitch_user = (array) $twitch_user;
                $streamer->save();
            }
        }

        // add YT data
        $ytStreamers = Streamer::whereNotNull('youtube_channel_id')->get();
        foreach ($ytStreamers as $streamer) {
            $url = "https://www.googleapis.com/youtube/v3/search";
            $url = "https://www.googleapis.com/youtube/v3/channels";

            $client = new \GuzzleHttp\Client();
            $response = $client->get($url, [
                'query' =>
                    [
                        'key' => env('YOUTUBE_API_KEY'),
                        'id' => $streamer->youtube_channel_id,
                        'part' => 'statistics,snippet'
                    ]
            ]);
            $json = json_decode($response->getBody()->getContents(), true);
            $streamer->youtube_channel = (array) data_get($json, 'items.0');
            $streamer->save();
        }
    }
}
