<div class="content-card">
    <div class="content-card__header">

        @isset($views)
            <div class="content-card__views">{!! $views !!}</div>
        @endisset
        @isset($image)
            <img class="content-card__image mr-3" src="{!! $image !!}"/>
        @endisset
        @isset($title)
            <div class="content-card__title">{{$title}}</div>
        @endisset
    </div>
     {!! $slot !!}
</div>