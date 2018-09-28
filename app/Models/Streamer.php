<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 * @property String $website
 * @property String $twitter
 * @property Carbon $last_online
 */
class Streamer extends Model
{
    protected $fillable = [
        'twitch_username',
        'twitch_user_id',
        'data',
        'is_online',
        'website',
        'twitter'
    ];
    protected $casts = ['data' => 'array', 'last_online' => 'datetime'];

    protected $appends = ['twitch_profile_image_url', 'twitch_url'];

    public function setIsOnlineAttribute($val)
    {
        if ($val) {
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

    public function getWebsiteAttribute()
    {
        return array_get($this->data, 'website');
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
        // - for local testing
        if (
            app()->environment() != 'production' &&
            $this->twitch_username == 'Andrey_Azimov'
        ) {
            return true;
        }

        if (!$this->last_online) {
            return false;
        }

        // - if "was online in the last 30 mins" - return true
        return (
            $this->last_online->timestamp >
            (new Carbon())->subMinutes(30)->timestamp
        );
    }

    /*
     * Twitch Stuff
     */
    public function getTwitchUrlAttribute()
    {
        return 'https://twitch.tv/' . $this->twitch_username;
    }

    public function getTwitchUsernameAttribute()
    {
        return array_get($this->data, 'twitch.user.display_name', '');
    }

    public function getTwitchProfileImageUrlAttribute()
    {
        return array_get($this->data, 'twitch.user.profile_image_url', '');
    }

    public function getTwitchProfileDescriptionAttribute()
    {
        return array_get($this->data, 'twitch.user.description', '');
    }

    public function getTwitchViewsAttribute()
    {
        return $this->number_format_short(
            intval(array_get($this->data, 'twitch.user.view_count', 0))
        );
    }

    public function getTweetTwitchLiveUrlAttribute()
    {
        if ($this->twitter) {
            $text =
                '🚢 @' .
                $this->twitter .
                ' is now shipping live on Twitch! ' .
                $this->twitch_url .
                ' via @shipstreams';
        } else {
            $text =
                '🚢️ ' .
                $this->twitch_username .
                ' is now shipping live on Twitch! ' .
                $this->twitch_url .
                ' via @shipstreams';
        }

        $url = "https://twitter.com/intent/tweet?text=" . $text;
        return $url;
    }
}
