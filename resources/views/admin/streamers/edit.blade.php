{!! View::make('decoy::shared.form._header', $__data)->render() !!}
<div>
    <fieldset>
        <div class="legend">
            {{ (empty($item)? 'New' : 'Edit') }}
        </div>

        {!! Former::text('alias') !!}
        {!! Former::text('twitch_username') !!}
        {!! Former::text('twitch_user_id') !!}
        {!! Former::text('youtube_channel_id') !!}
        {!! Former::text('slug') !!}
        {!! Former::select('streamer_main_channel')->options([
        'twitch'=>'Twitch',
        'youtube'=>'YouTube'
        ]) !!}

    </fieldset>

    <fieldset>
        <div class="legend">
            Links
        </div>

        {!! Former::text('website') !!}
        {!! Former::text('twitter') !!}
        {!! Former::text('email') !!}

    </fieldset>


</div>

{!! View::make('decoy::shared.form._footer', $__data)->render() !!}

