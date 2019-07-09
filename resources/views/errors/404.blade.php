@extends('layouts.app')

@section('title')
<title>{{ Lang::get('messages.errors.404') }}</title>
<link href="{{ asset(env('THEME')) }}/css/style-pagenavi.css" rel="stylesheet" type="text/css">
@endsection

@section('main')
    <aside>
        {!! $nav->asUl() !!}
        @include('layouts.slogan')
    </aside>
    <main>
    <h1 class="contour">{{ Lang::get('messages.errors.404') }}</h1>
    <div class="contour">
        <p>{{ Lang::get('messages.errors.404-text') }}</p>
    </div>
@endsection
