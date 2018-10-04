<?php
namespace App\Console\Commands;

use App\Models\Streamer;
use Illuminate\Console\Command;
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
    }
}
