<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.meta')
</head>
<body>
<div id="app">

    @if(config('shipstreams.ph-alert.show'))
        <a href="{{config('shipstreams.ph-alert.url')}}" target="_blank" class="ph-alert">
            We are live on Product Hunt right meow! 😻
        </a>
    @endif
    
    
    @include('layouts.partials.header')
    <div class="container mt-5 mb-4">

        <div class="mt-5 mb-4 ">
            @yield('content')
        </div>

    </div>
</div>
<script src="{{mix('js/app.js')}}"></script>
 
</body>
</html>
