@extends('layouts.app')

@section('meta')
@include('layouts.partials.meta')
@include('layouts.partials.meta-seo')
@endsection

@section('header')
<div class="container">
    <div class="header__headlines">
        <h1>Shipstreams Kit</h1>
        <p>Getting started with<br>streaming yourself</p>
    </div>

    <p class="header__intro">
        Here you can find helpful guides on setting up your own stream and dealing with various issues.
    </p>
</div>
@endsection
 

@section('content')
        <div class="row">
            @foreach($kitResources as $resource)
                <div class="col-xs-12 col-md-6 resource-column">
                    <a href="{{ $resource->link }}" target="_blank" class="card resource">
                        <h3 class="resource__header">{{ $resource->title }}</h3>
                        <p>{{ $resource->description }}</p>

                        <div class="resource__topics-list">
                            @foreach($resource->topics as $topic)
                                <span class="resource__topic">
                        {{ $topic }}
                    </span>
                            @endforeach
                        </div>

                        <button class="btn resource__cta">Visit guide</button>
                    </a>
                </div>
            @endforeach
        </div>
        
@endsection
