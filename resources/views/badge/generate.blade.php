@extends('layouts.app')

@section('meta')
@include('layouts.partials.meta')
@include('layouts.partials.meta-seo')
@endsection

@section('header')
<div class="container">
    <div class="header__headlines">
        <h1>Shipstreams badge</h1>
        <p>Generate a badge <br /> for your stream</p>
    </div>
</div>
@endsection

@section('content')

    <div class="container mt-5 mb-4">

        <div class="mt-5 mb-4 ">
            <badge-generator></badge-generator>
        </div>

    </div>

@endsection
