@section('nope')
    <?php /** @var \App\Models\Streamer $streamer */ ?>
@endsection
<div class="col-12 col-md-6 col-lg-4">
    <div class="streamer @if($streamer->is_online) is-streaming @endif">
        <div class="streamer__image-wrap">
            <a target="_blank" href="{{$streamer->twitch_url}}">
                <img class="streamer__image" src="{{$streamer->twitch_profile_image_url}}"/>
            </a>
        </div>
        <a target="_blank" href="{{$streamer->twitch_url}}" class="streamer__name">{{$streamer->twitch_username}}</a>
        @if($streamer->twitch_profile_description)
            <div class="streamer__description">{{$streamer->twitch_profile_description}}</div>
        @endif
        @if($streamer->is_online)
            <div class="streamer__status">
                streaming now
            </div>
        @else
            <div class="streamer__status">
                @if($streamer->last_online)
                    <strong> last streamed: {{$streamer->last_online->toDateString()}}</strong>
                    {{--<a href="#">View latest Video</a>--}}
                @endif
            </div>
        @endif
        <div class="streamer__footer">
            <div class="streamer__footer-social">
                <ul>
                    @if($streamer->twitter)
                    <li>
                        <a target="_blank" data-toggle="tooltip" data-placement="bottom" title="Follow on Twitter" href="https://twitter.com/{{$streamer->twitter}}"><i
                                    class="fab fa-twitter"></i></a>
                    </li>
                    @endif
                    
                    @if($streamer->website)
                    <li>
                        <a target="_blank" data-toggle="tooltip" data-placement="bottom" title="Website" href="{{$streamer->website}}"><i
                                    class="fas fa-link"></i></a>
                    </li>
                    @endif
                        
                    <li>
                        <a target="_blank" data-toggle="tooltip" data-placement="bottom" title="Open Twitch Profile"
                           href="{{$streamer->twitch_url}}"><i class="fab fa-twitch"></i></a>
                    </li>
                </ul>
            </div>
            <div class="streamer__footer-views">
                <i class="far fa-eye"></i> {{$streamer->twitch_views}}
            </div>
        </div>
        @if($streamer->is_online)
            <div class="streamer__footer-live">
                <a target="_blank" href="{{$streamer->tweet_twitch_live_url}}" class="streamer__footer-live">
                    Tweet about this stream
                </a>
            </div>
        @endif


    </div>

</div>