@extends('admin.layouts.app')

@section('title')
<title>Admin: {!! $article->name !!}</title>
@endsection

@section('main')
    <aside>
        {!! $nav->asUl() !!}
        @include('layouts.slogan')
    </aside>
    <main class="articles">
        <nav>
            {!! $nav_back_up !!}
        </nav>
        <h1 class="contour">{{ $article->name }}</h1>
        <div class="contour">
            {!! $article->text !!}
            <nav>
                {!! $nav_back->asUl() !!}
            </nav>
        </div>
    </main>
@endsection
