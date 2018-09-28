@extends('layouts.app')
@section('meta')
    @include('layouts.partials.meta')
    @include('layouts.partials.meta-seo')
@endsection
@section('header')

    <div class="container">
        <div class="header__headlines">
            <h1>Submit Yourself</h1>
            <p> Grow our <br> community! </p>
        </div>
    </div>

@endsection
@section('content')
    @if(request()->get('success'))
        @include('submit.partials.success')
    @else
        @include('submit.partials.form')
    @endif
@endsection