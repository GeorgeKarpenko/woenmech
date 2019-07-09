@extends('layouts.app')

@section('title')
<title>{!! $page->name !!}</title>
@endsection


@section('header')
<p>{{ Lang::get('messages.header') }}</p>
@endsection

@section('main')
    <aside>
        {!! $navPullDown->asUl() !!}
        @include('layouts.slogan')
    </aside>
    <main>
        <nav>
            {!! $nav_back_up !!}
        </nav>
        @if($page->img)
        <h1 class="contour">{!! $page->name !!}</h1>
        <nav id="nav">
            <div id="photo">
                <p>{!! $page->imgText !!}</p>
                <img src="{{ $page->img }}">
                {!! $nav->asUl() !!}
            </div>
        </nav>
        @else
        <nav class="contour">
            <div>
                <h1>{!! $page->name !!}</h1>
                {!! $nav->asUl() !!}
            </div>
        </nav>
        @endif
        <div class="contour">
            <ul id="articles">
                @foreach($articles as $article)
                    @if($article->status == 4)
                    <li>
                        <a href="{{ $page->path . '/' . $article->path }}">{{ $article->name }}</a>
                    </li>
                    @else
                    <li>
                        <p>{{ $article->name }}</p>
                        <audio controls>
                            <source src="{{ $article->audio }}" type="audio/mpeg">
                            {{ Lang::get('messages.audio_tag') }}
                            <a href="{{ $article->audio }}">{{ Lang::get('messages.download_music') }}</a>.
                        </audio>
                    </li>
                    @endif
                @endforeach
            </ul>
            @if($page->imgLeft)
            <div id="items">
                <div>
                    @foreach($page->imgLeft as $img)
                        <img src="{{ $img }}">
                    @endforeach
                </div>
                <div id="text">{!! $page->text !!}</div>
                
                <div>
                    @foreach($page->imgRight as $img)
                        <img src="{{ $img }}">
                    @endforeach
                </div>
            </div>
            @else
                <div>
                    {!! $page->text !!}
                </div>
            @endif
            <nav>
                {!! $nav_back->asUl() !!}
            </nav>
        </div>
    </main>
@endsection
