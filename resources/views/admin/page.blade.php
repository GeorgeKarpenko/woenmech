@extends('admin.layouts.app')

@section('title')
<title>Admin: {!! $page->name !!}</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection

@section('main')
    <nav class="box-shadow">
        <div>
            <h1>{!! $page->name !!}</h1>
            @if($nav)
            {!! \App::isLocale('en') ?
            Form::open(['url' => route('en.admin.pages.priority',['path' => $page->path]),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
            :
            Form::open(['url' => route('admin.pages.priority',['path' => $page->path]),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
            <table class="sortable-table">
                <thead>
                    <tr>
                        <th>{{ Lang::get('messages.section_name') }}</th>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                @foreach($nav as $section)
                    <tr>
                        <td><i class="handle"></i>
                            {{ Form::number('ids[]', $section->id, ['readonly' => 'true', 'style' => 'display: none']) }}
                            <a href="{{ \App::isLocale('en') ? route('en.admin.pages.index', $section->path) : route('admin.pages.index', $section->path) }}">{{ $section->name }}</a>
                        </td>
                        <td>
                            <a href="{{ \App::isLocale('en') ? route('en.admin.pages.edit', ['path' => $page->path, 'page' => $section->id]) : route('admin.pages.edit', ['path' => $page->path, 'page' => $section->id]) }}">{{ Lang::get('messages.edit') }}</a>
                        </td>
                        <td>
                            <a href="{{ \App::isLocale('en') ? route('en.admin.pages.delete', ['path' => $page->path, 'page' => $section->id]) : route('admin.pages.delete', ['path' => $page->path, 'page' => $section->id]) }}">{{ Lang::get('messages.remove') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody> 
            </table>
            <script>
                var fixHelper = function(e, ui) {
                    ui.children().each(function() {
                        $(this).width($(this).width());
                    });
                    return ui;
                };
                $('.sortable-table tbody').sortable({
                    helper: fixHelper
                });
            </script>
            {!! Form::submit(Lang::get('messages.maintain_priority')); !!}
            {!! Form::close() !!}
            @endif
            <nav>
                <ul><li><a href="{{ \App::isLocale('en') ? route('en.admin.pages.create', $page->path) : route('admin.pages.create', $page->path) }}">{{ Lang::get('messages.add') }}</a></li></ul>
            </nav>
        </div>
    </nav>
    <main>
        <div class="contour">
        {!! \App::isLocale('en') ? 
        Form::open(['url' => route('en.admin.articles.priority',['path' => $page->path]),
        'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
        :
        Form::open(['url' => route('admin.articles.priority',['path' => $page->path]),
        'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
            <table class="sortable-table-articles">
                <thead>
                    <tr>
                        <th>{{ Lang::get('messages.article_title') }}</th>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td><i class="handle"></i>
                            {{ Form::number('ids[]', $article->id, ['readonly' => 'true', 'style' => 'display: none']) }}
                            @if ($article->status == 5)
                            <div>
                                <b>{{ $article->name }}</b>
                                <audio controls>
                                    <source src="{{ $article->audio }}" type="audio/mpeg">
                                    {{ Lang::get('messages.audio_tag') }}
                                    <a href="{{ $article->audio }}">{{ Lang::get('messages.download_music') }}</a>.
                                </audio>
                            </div>
                            @else
                                <a href="{{ \App::isLocale('en') ? route('en.admin.articles.index', ['path' => $page->path, 'article' => $article->path]) : route('admin.articles.index', ['path' => $page->path, 'article' => $article->path]) }}">{{ $article->name }}</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ \App::isLocale('en') ? route('en.admin.articles.edit', ['path' => $page->path, 'article' => $article->id]) : route('admin.articles.edit', ['path' => $page->path, 'article' => $article->id]) }}">{{ Lang::get('messages.edit') }}</a>
                        </td>
                        <td>
                            <a href="{{ \App::isLocale('en') ? route('en.admin.articles.delete', $article) : route('admin.articles.delete', $article) }}">{{ Lang::get('messages.remove') }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody> 
            </table>
            
            <script>
                var fixHelper = function(e, ui) {
                    ui.children().each(function() {
                        $(this).width($(this).width());
                    });
                    return ui;
                };
                $('.sortable-table-articles tbody').sortable({
                    helper: fixHelper
                });
            </script>
            {!! Form::submit(Lang::get('messages.maintain_priority')); !!}
            {!! Form::close() !!}
            
            <nav>
                <ul>
                    <li><a href="{{ \App::isLocale('en') ? route('en.admin.articles.create', $page->path) : route('admin.articles.create', $page->path) }}">{{ Lang::get('messages.add_article') }}</a></li>
                    <li><a href="{{ \App::isLocale('en') ? route('en.admin.audio.create', $page->path) : route('admin.audio.create', $page->path) }}">{{ Lang::get('messages.add_audio') }}</a></li>
                </ul>
            </nav>
            <nav>
                {!! $nav_back->asUl() !!}
            </nav>
        </div>
    </main>
@endsection
