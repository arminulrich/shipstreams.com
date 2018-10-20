<?php
namespace App\Models\Values;

interface ChannelInterface
{
    public function profile_name(): string;
    public function profile_image_url(): string;
    public function profile_description(): string;
    public function total_views(): string;
    public function reference_id(): string;

    public function tweet_live_text(): string;
    public function telegram_live_text(): string;
    public function tweet_live_url(): string;

    public function channel_url(): string;

    public function stream_title(): string;
}
