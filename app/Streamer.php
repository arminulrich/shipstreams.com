<?php
namespace App;

use Illuminate\Support\Facades\Cache;
use romanzipp\Twitch\Twitch;

class Streamer
{
    public $username;
    public $twitch_data = [];
    public $twitch_video_data = [];
    public $twitch_stream_data = [];

    private function getCacheKey($key = "base")
    {
        return 'steamer-cache-' . md5($this->username) . '-' . $key;
    }
    /**
     * Streamer constructor.
     *
     * @param $username
     */
    public function __construct($username)
    {
        $this->username = $username;
        /** @var Twitch $twitch */
        $twitch = app(Twitch::class);
        $this->twitch_data = Cache::remember(
            $this->getCacheKey('user-result'),
            60,
            function () use ($twitch) {
                return array_get(
                    $twitch->getUserByName($this->username)->data,
                    0,
                    []
                );
            }
        );
        $this->twitch_stream_data = Cache::remember(
            $this->getCacheKey('stream-data'),
            60,
            function () use ($twitch) {
                return collect(
                    $twitch->getStreamsByUserId($this->user_id())->data
                );
            }
        );

        $this->twitch_video_data = Cache::remember(
            $this->getCacheKey('video-data'),
            60,
            function () use ($twitch) {
                return collect(
                    $twitch->getVideosByUser($this->user_id())->data
                );
            }
        );
    }

    public function has_active_stream()
    {
        return $this->twitch_stream_data->count();
    }

    public function stream_title()
    {
        $stream = $this->twitch_data = array_get(
            $this->twitch_stream_data,
            0,
            []
        );

        return data_get($stream, 'title', '');
    }

    public function videos()
    {
        return $this->twitch_video_data->take(10);
    }

    public function profile_pic()
    {
        return data_get($this->twitch_data, 'profile_image_url');
    }

    public function user_id()
    {
        return intval(data_get($this->twitch_data, 'id'));
    }

    public function view_count()
    {
        return intval(data_get($this->twitch_data, 'view_count', 0));
    }

    public function stats()
    {

    }
    public function description()
    {
        return data_get($this->twitch_data, 'description');
    }
    public function name()
    {
        return $this->username;
    }
}
