<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @yield('meta')
</head>
<body>

<div id="app">
    <div class="site-content">

        @if(config('shipstreams.ph-alert.show'))
            <a href="{{config('shipstreams.ph-alert.url')}}" target="_blank" class="ph-alert">
                We are live on Product Hunt right meow! 😻
            </a>
        @endif

        @include('layouts.partials.header')

        @yield('header')

        <div class="container mt-5 mb-4">

            <div class="mt-5 mb-4 ">
                @yield('content')
            </div>

        </div>
    </div>
    @include('layouts.partials.footer')
</div>
<script src="{{mix('js/app.js')}}"></script>

<script>
    (function(d, h, m){
        var js, fjs = d.getElementsByTagName(h)[0];
        if (d.getElementById(m)){return;}
        js = d.createElement(h); js.id = m;
        js.onload = function(){
            window.makerWidgetComInit({
                position: "left",
                widget: "r9uqyc6u0hyqxsbw-0tyc1jcafgzz68zc-m4go6a6ahubralb1"
            })};
        js.src = "https://makerwidget.com/js/embed.js";
        fjs.parentNode.insertBefore(js, fjs)
    }(document, "script", "dhm"))
</script>
</body>
</html>
