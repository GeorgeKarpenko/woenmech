@extends('admin.layouts.app')

@section('title')
<title>$article->name</title>
<link rel="stylesheet" type="text/css" href="/colorbox-master/example1/colorbox.css">

<script src="{{ asset('/js/ckeditor_4.11.4_full/ckeditor.js') }}" type="text/javascript" charset="utf-8" ></script>
<script src="{{ asset('/colorbox-master/jquery.colorbox-min.js') }}" type="text/javascript" charset="utf-8" ></script>
<script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>
@endsection

@section('main')
    <main>
        <div>
            @if (isset($article->name)) 
            {!! \App::isLocale('en') ? 
            Form::open(['url' => route('en.admin.articles.update', ['path' => $path, 'id'=> $article->id]),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
            :
            Form::open(['url' => route('admin.articles.update', ['path' => $path, 'id'=> $article->id]),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
            
            @else
            {!! \App::isLocale('en') ? 
            Form::open(['url' => route('en.admin.articles.make', $path),
            'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data'])
            :
            Form::open(['url' => route('admin.articles.make', $path),
            'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data']) !!}
            @endif
            <p>{{ Lang::get('messages.name') }}</p>
            {{ Form::text('name', isset($article->name) ? $article->name : '') }}

            <p>URL</p>
            {{ Form::text('path', isset($article->path) ? $article->path : '') }}
            <p>{{ Lang::get('messages.text') }}</p>
            {{ Form::textarea('text', isset($article->text) ? $article->text : '', ['id' => "editor1"]) }}

            @if (!isset($article->name)) 
                <p>{{ Lang::get('messages.third-party_author') }}</p>
                {{ Form::text('author', isset($article->author) ? $article->author : '') }}
            @endif
            {{ Form::number('status', '4', ['readonly' => 'true', 'style' => 'display: none']) }}

            <hr>
            <h2 class="width">{{ Lang::get('messages.english') }}</h2>
            <p>{{ Lang::get('messages.name') }}</p>
            {{ Form::text('enName', isset($page->enName) ? $page->enName : '') }}

            <p>{{ Lang::get('messages.text') }}</p>
            {{ Form::textarea('enText', isset($page->enText) ? $page->enText : '', ['id' => "editor2"]) }}

            @if (!isset($article->name)) 
                <p>{{ Lang::get('messages.third-party_author') }}</p>
                {{ Form::text('enAuthor', isset($article->enAuthor) ? $article->enAuthor : '') }}
            @endif

            <a id="back" href="{{ env('APP_URL') . str_replace('/articles', '', isset($article->name) ? str_replace('/' . $article->id . '/edit', '', $_SERVER['REQUEST_URI']) : str_replace('/create', '', $_SERVER['REQUEST_URI'])) }}"><span>{{ Lang::get('messages.backward') }}</span></a>
            {!! Form::submit(Lang::get('messages.save')); !!}
            {!! Form::close() !!}
        </div>
    </main>

<script>
        var editor = CKEDITOR.replace( 'editor1',{
                 filebrowserBrowseUrl : '/elfinder/ckeditor' 
        } );
        var editor1 = CKEDITOR.replace( 'editor2',{
                 filebrowserBrowseUrl : '/elfinder/ckeditor' 
        } );
</script>
@endsection
