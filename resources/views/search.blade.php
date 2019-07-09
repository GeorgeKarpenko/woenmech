@extends('layouts.app')

@section('title')
<title>{{ Lang::get('messages.search') }}: {{ $search }}</title>
<link href="{{ asset(env('THEME')) }}/css/style-pagenavi.css" rel="stylesheet" type="text/css">
@endsection

@section('main')
    <aside>
        {!! $nav->asUl() !!}
        @include('layouts.slogan')
    </aside>
    <main>
    <h1 class="contour search">{{ Lang::get('messages.search') }}: {{ $search }}</h1>
    <div class="contour search">
        @foreach ($articles as $article)
            <h2><a href="{!! $article->path !!}">{!! $article->name !!}</a></h2>
            <div>{!! explode("</p>", strip_tags($article->text, '<p>'))[0] . '</p>' !!}</div>
        @endforeach
        {{ $articles->appends(\Illuminate\Support\Facades\Input::except('_token'))->links() }}
    </div>
@endsection
