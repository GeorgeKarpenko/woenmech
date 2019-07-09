@extends('layouts.app')

@section('title')
<title>{{ $article->name }}</title>
@endsection

@section('main')
    <aside>
        {!! $nav->asUl() !!}
        @include('layouts.slogan')
    </aside>
    <main>
        <nav>
            {!! $nav_back_up !!}
        </nav>
        <h1 class="contour">{{ $article->name }}</h1>
        <div class="contour">
            {!! $article->text !!}
            <footer>
                <p>{{ $article->created }}</p>
                <p>{{ $article->author }}</p>                
            </footer>
            <nav>
                {!! $nav_back->asUl() !!}
            </nav>
        </div>
    </main>
@endsection
