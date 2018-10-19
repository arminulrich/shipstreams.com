<?php
namespace App\Models;

use Bkwld\Decoy\Models\Base;
use Illuminate\Database\Eloquent\Model;

class Submission extends Base
{
    protected $casts = ['data' => 'array'];

    public function getEmailAttribute()
    {
        return array_get($this->data, 'email');
    }
    public function getTwitchUsernameAttribute()
    {
        return array_get($this->data, 'twitch_username');
    }
    public function getYoutubeChannelUrlAttribute()
    {
        return array_get($this->data, 'youtube_channel_url');
    }
    public function getTwitterHandleAttribute()
    {
        return array_get($this->data, 'twitter_handle');
    }
    public function getWebsiteAttribute()
    {
        return array_get($this->data, 'website');
    }

    public function getAlreadyAddedAttribute()
    {
        $added = Streamer
            ::whereRaw(
                'lower(twitch_username) like "%' .
                    array_get($this->data, "twitch_username") .
                    '%"'
            )
            ->first();
        if ($added) {
            return "✅";
        }
        return "";
    }
}
