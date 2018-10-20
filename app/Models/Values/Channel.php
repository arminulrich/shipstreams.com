<?php
namespace App\Models\Values;

use App\Models\Streamer;
use Illuminate\Contracts\Support\Arrayable;

abstract class Channel implements ChannelInterface, Arrayable
{
    protected $data;
    /**
     * @var Streamer
     */
    protected $streamer;

    /**
     * Channel constructor.
     *
     * @param $data
     */
    public function __construct(Streamer $streamer, $data = [])
    {
        if (!is_array($data)) {
            $data = [];
        }
        $this->data = $data;
        $this->streamer = $streamer;
    }

    public function toArray()
    {
        return [
            'profile_name' => $this->profile_name(),
            'profile_image_url' => $this->profile_image_url(),
            'profile_description' => $this->profile_description(),
            'total_views' => $this->total_views(),
            'reference_id' => $this->reference_id(),
            'tweet_live_text' => $this->tweet_live_text(),
            'telegram_live_text' => $this->telegram_live_text(),
            'tweet_live_url' => $this->tweet_live_url(),
            'channel_url' => $this->channel_url(),
            'stream_title' => $this->stream_title()
        ];
    }

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
}
