<?php
namespace App\Console\Commands;

use App\Models\Streamer;
use Illuminate\Console\Command;
use romanzipp\Twitch\Twitch;

class RefreshStreamersFromJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:streamers_json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add streamers from json to database';

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

        $streamers_file = (
            app()->environment() != 'production'
                ? 'streamers_dev.json'
                : 'streamers.json'
        );

        $streamers_json = collect(
            json_decode(file_get_contents(app_path($streamers_file)), true)
        );

        $twitch_user_names = $streamers_json->pluck('twitch_username');
        $allTwitchStreamers = Streamer::all()->pluck('twitch_username');

        $twitchStreamsToAdd = $twitch_user_names->diff($allTwitchStreamers);
        if ($twitchStreamsToAdd->count()) {
            $twitch_data_users = $twitch->getUsersByNames(
                $twitchStreamsToAdd->toArray()
            )->data;

            foreach ($twitch_data_users as $twitch_user) {
                // guard again
                $existsByTwitchUsername = Streamer
                    ::whereTwitchUsername(data_get($twitch_user, 'login'))
                    ->first();

                $existsByTwitchId = Streamer
                    ::whereTwitchUserId(data_get($twitch_user, 'id'))
                    ->first();

                if ($existsByTwitchUsername || $existsByTwitchId) {
                    continue;
                }

                $data = [];
                array_set($data, 'twitch.user', $twitch_user);

                $s = Streamer::firstOrNew([
                    'twitch_user_id' => data_get($twitch_user, 'id')
                ]);
                $s->twitch_username = data_get($twitch_user, 'login');
                $s->twitch_user = (array) $twitch_user;

                $s->data = $data;
                $s->save();
            }
        }
    }
}
