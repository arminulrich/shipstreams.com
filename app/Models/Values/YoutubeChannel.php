<?php
namespace App\Models\Values;

class YoutubeChannel extends Channel
{
    public function profile_name(): string
    {
        return array_get($this->data, 'youtube.channel.snippet.title', '');
    }

    public function profile_image_url(): string
    {
        return array_get(
            $this->data,
            'youtube.channel.snippet.thumbnails.medium.url',
            ''
        );
    }

    public function profile_description(): string
    {
        return array_get(
            $this->data,
            'youtube.channel.snippet.description',
            ''
        );
    }

    public function total_views(): string
    {
        return $this->number_format_short(
            intval(
                array_get(
                    $this->data,
                    'youtube.channel.statistics.viewCount',
                    0
                )
            )
        );
    }

    public function reference_id(): string
    {
        return $this->streamer->youtube_channel_id;
    }

    public function tweet_live_text(): string
    {
        $text = collect();

        if ($this->streamer->twitter) {
            $text->push(
                '🚢 @' . $this->streamer->twitter . ' is now shipping live! '
            );
        } else {
            $text->push(
                '🚢️ "' . $this->profile_name() . '" is now shipping live! '
            );
        }
        if ($this->stream_title()) {
            $text->push("📹 \"" . $this->stream_title() . "\"");
        }

        $text->push(
            "👉 " . $this->streamer->shipstreams_url . ' via @shipstreams'
        );
        return $text->implode("\n");
    }

    public function telegram_live_text(): string
    {
        $text = collect();

        $text->push(
            '🚢️ "' . $this->profile_name() . '" is now shipping live! '
        );

        if ($this->stream_title()) {
            $text->push("📹 \"" . $this->stream_title() . "\"");
        }

        $text->push("👉 " . $this->streamer->shipstreams_url);
        return $text->implode("\n");
    }

    public function tweet_live_url(): string
    {
        $url =
            "https://twitter.com/intent/tweet?text=" .
            urlencode($this->tweet_live_text());
        return $url;
    }

    public function channel_url(): string
    {
        return "https://youtube.com/channel/" . $this->reference_id();
    }

    public function stream_title(): string
    {
        return array_get($this->data, 'youtube_stream.snippet.title', '');
    }
}
