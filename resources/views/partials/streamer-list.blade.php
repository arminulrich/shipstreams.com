<div class="mb-5">
    @foreach($streamers as $streamer)
        <?PHP /** @var \App\Streamer $streamer */ ?>
        @component('card')
            @slot('image'){!! $streamer->profile_pic() !!}@endslot
            @slot('title')<a href="https://twitch.tv/{{$streamer->name()}}" target="_blank">{{$streamer->name()}}</a>
            <br>
            <small>{{$streamer->description()}}</small>@endslot
            @slot('views')<i class="far fa-eye"></i> {{$streamer->view_count()}}@endslot
            @if($streamer->videos()->count())
                <div class="content-card__caption">

                    <strong>Videos:</strong>
                    <br>
                    <ul class="mb-0">
                        @foreach($streamer->videos() as $video)
                            <li>
                                <a target="_blank" href="{{$video->url}}">
                                    @if($video->title)
                                        {{$video->title}}
                                    @else
                                        {{$video->url}}
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! $streamer->stats() !!}
        @endcomponent
    @endforeach
</div>