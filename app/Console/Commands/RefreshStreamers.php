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

        $streamers_file = (
            app()->environment() != 'production'
                ? 'streamers_dev.json'
                : 'streamers.json'
        );

        $streamers_json = collect(
            json_decode(file_get_contents(app_path($streamers_file)), true)
        );

        // - fetch twitch data in batch
        $twitch_user_names = $streamers_json
            ->pluck('twitch_username')
            ->toArray();

        $twitch_data_users = $twitch->getUsersByNames($twitch_user_names);
        $twitch_data_streams = $twitch->getStreamsByUserNames(
            $twitch_user_names
        );

        $streamers_with_data = $streamers_json // - map streams only to see if the user is online
            ->transform(function ($streamer) use ($twitch_data_users) {
                $data = collect($twitch_data_users->data)->firstWhere(
                    'login',
                    $streamer['twitch_username']
                );
                array_set($streamer, 'data.twitch.user', (array) $data);
                return $streamer;
            })
            ->transform(function ($streamer) use ($twitch_data_streams) {
                $user_id = data_get($streamer, 'data.twitch.user.id');
                $hasStream = (bool) collect(
                    $twitch_data_streams->data
                )->firstWhere('user_id', $user_id);

                array_set($streamer, 'is_online', $hasStream);

                return $streamer;
            })
            ->transform(function ($streamer) use ($twitch) {
                // - fetch videos and sleep 3 sec so we dont get over api limit
                $user_id = data_get($streamer, 'data.twitch.user.id');

                array_set(
                    $streamer,
                    'data.twitch.videos',
                    (array) collect($twitch->getVideosByUser($user_id)->data)
                        ->take(3)
                        ->transform(function ($v) {
                            return (array) $v;
                        })
                        ->toArray()
                );

                sleep(3);
                return $streamer;
            });

        foreach ($streamers_with_data as $streamer) {
            $s = Streamer::firstOrNew([
                'twitch_username' => $streamer['twitch_username']
            ]);
            $s->twitch_user_id = intval(
                data_get($streamer, 'data.twitch.user.id')
            );
            $s->data = $streamer['data'];
            $s->fill(
                collect($streamer)
                    ->except('data')
                    ->toArray()
            );
            $s->save();
        }

        // - delete streamers who are not in json
        $removedStreamers = Streamer
            ::whereNotIn('twitch_username', $twitch_user_names)
            ->get();
        $removedStreamers->each->delete();
    }
}
