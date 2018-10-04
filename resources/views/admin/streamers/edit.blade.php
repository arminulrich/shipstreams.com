{!! View::make('decoy::shared.form._header', $__data)->render() !!}
<div>
    <fieldset>
        <div class="legend">
            {{ (empty($item)? 'New' : 'Edit') }}
        </div>

 
        {!! Former::text('twitch_username') !!}
 
    </fieldset>
 
    
</div>

{!! View::make('decoy::shared.form._footer', $__data)->render() !!}

