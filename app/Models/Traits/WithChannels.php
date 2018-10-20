<?php
namespace App\Models\Traits;

use App\Models\Streamer;
use App\Models\Values\ChannelInterface;
use App\Models\Values\TwitchChannel;
use App\Models\Values\YoutubeChannel;

trait WithChannels
{
    public function twitch(): TwitchChannel
    {
        return new TwitchChannel($this, $this->data);
    }

    public function youtube(): YoutubeChannel
    {
        return new YoutubeChannel($this, $this->data);
    }

    public function main_channel(): ChannelInterface
    {
        if ($this->streamer_main_channel == Streamer::MAIN_CHANNEL_TWITCH) {
            return $this->twitch();
        }
        return $this->youtube();
    }

    public function getTwitchAttribute()
    {
        return $this->twitch();
    }

    public function getYoutubeAttribute()
    {
        return $this->youtube();
    }

    public function getMainChannelAttribute()
    {
        return $this->main_channel();
    }
}
