<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.meta')
</head>
<body>
<div id="app">

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
