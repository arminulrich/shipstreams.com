<?php
namespace App\Models;

use App\Events\StreamerWentOnline;
use App\Models\Traits\TwitchAttributes;
use App\Models\Traits\WithChannels;
use App\Models\Values\Channel;
use App\Models\Values\TwitchChannel;
use Bkwld\Decoy\Models\Base;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Streamer
 *
 * @package App\Models
 *
 * @property String $twitch_username
 * @property String $twitch_views
 * @property String $twitch_profile_image_url
 * @property String $twitch_profile_description
 * @property String $tweet_twitch_live_url
 * @property String $twitch_url
 * @property String $shipstreams_url
 * @property String $website
 * @property String $twitter
 * @property Carbon $last_online
 */
class Streamer extends Base
{
    use SoftDeletes;
    use WithChannels;

    const MAIN_CHANNEL_TWITCH = 'twitch';
    const MAIN_CHANNEL_YOUTUBE = 'youtube';

    public function getSlugKeyName(): string
    {
        return "slug";
    }

    protected $fillable = [
        'twitch_username',
        'twitch_user_id',
        'data',
        'is_online',
        'twitch_stream',
        'website',
        'twitter'
    ];
    protected $casts = ['data' => 'array', 'last_online' => 'datetime'];
    protected $appends = ['main_channel', 'is_online'];

    public function setIsOnlineAttribute($val)
    {
        // - special game filters (test)
        if ($this->twitch_username) {
            if (
                !in_array($this->twitch_stream_game_id, ["509670"]) &&
                intval($this->twitch_stream_game_id) > 0
            ) {
                return false;
            }
        }

        if ($val) {
            if ($this->last_online) {
                if (
                    $this->last_online->timestamp <
                    (new Carbon())->subHours(4)->timestamp
                ) {
                    event(new StreamerWentOnline($this));
                }
            } else {
                event(new StreamerWentOnline($this));
            }

            $this->attributes['last_online'] = new Carbon();
        }
    }

    public function setWebsiteAttribute($val)
    {
        $data = $this->data;
        array_set($data, 'website', $val);
        $this->data = $data;
    }

    public function setTwitterAttribute($val)
    {
        $data = $this->data;
        array_set($data, 'twitter', $val);
        $this->data = $data;
    }
    public function setEmailAttribute($val)
    {
        $data = $this->data;
        array_set($data, 'email', $val);
        $this->data = $data;
    }

    public function getWebsiteAttribute()
    {
        return array_get($this->data, 'website');
    }

    public function getEmailAttribute()
    {
        return array_get($this->data, 'email');
    }

    public function setYoutubeChannelAttribute($val)
    {
        $data = $this->data;
        array_set($data, 'youtube.channel', $val);
        $this->data = $data;
    }

    public function getTwitterAttribute($val)
    {
        return array_get($this->data, 'twitter');
    }

    /*
     * Helpers
     */
    function number_format_short($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } elseif ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } elseif ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } elseif ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }
        // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
        // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ($precision > 0) {
            $dotzero = '.' . str_repeat('0', $precision);
            $n_format = str_replace($dotzero, '', $n_format);
        }
        return $n_format . $suffix;
    }

    /*
     * General
     */

    public function getIsOnlineAttribute()
    {
        // - special game filters (test)
        if ($this->twitch_username) {
            if (
                !in_array($this->twitch_stream_game_id, ["509670"]) &&
                intval($this->twitch_stream_game_id) > 0
            ) {
                return false;
            }
        }

        // - for local testing
        if (
            app()->environment() != 'production' &&
            $this->twitch_username == 'andrey_azimov'
        ) {
            return true;
        }

        if (!$this->last_online) {
            return false;
        }

        // - if "was online in the last 5 mins" - return true
        return (
            $this->last_online->timestamp >
            (new Carbon())->subMinutes(6)->timestamp
        );
    }

    public function getOgImageTextAttribute()
    {
        return $this->twitch_username . ' is shipping live now! 🚢';
    }

    public function getYoutubeUrlAttribute()
    {
        return 'https://youtube.com/channel/' . $this->youtube_channel_id;
    }

    public function getMainUrlAttribute()
    {
        if ($this->streamer_main_channel == Streamer::MAIN_CHANNEL_TWITCH) {
            return $this->youtube_url;
        }
        return $this->twitch_url;
    }

    public function getShipstreamsUrlAttribute()
    {
        return url($this->slug);
    }

    /**
     * Admin Area Fields
     */
    public function getAdminTitleHtmlAttribute()
    {
        return $this->main_channel()->profile_name();
    }

    public function setYoutubeStreamAttribute($val)
    {
        $data = $this->data;
        array_set($data, 'youtube_stream', $val);
        $this->data = $data;
    }

    public function setTwitchStreamAttribute($val)
    {
        $data = $this->data;
        array_set($data, 'twitch_stream', $val);
        $this->data = $data;
    }

    public function setTwitchUserAttribute($val)
    {
        $data = $this->data;
        array_set($data, 'twitch.user', $val);
        $this->data = $data;
    }

    public function getTwitchStreamAttribute($val)
    {
        return array_get($this->data, 'twitch_stream');
    }

    public function getTwitchStreamGameIdAttribute($val)
    {
        return array_get($this->data, 'twitch_stream.game_id', "");
    }
}
