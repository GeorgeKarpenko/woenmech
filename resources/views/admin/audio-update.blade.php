@extends('admin.layouts.app')

@section('title')
<title>$article->name</title>
<link rel="stylesheet" type="text/css" href="/colorbox-master/example1/colorbox.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
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

            <p>{{ Lang::get('messages.audio') }}</p>
            <div>
            {{ Form::text('audio', isset($article->audio) ? $article->audio : '', ['id' => "audio"]) }}
            <a href="" class="popup_selector btn btn-primary" data-inputid="audio">{{ Lang::get('messages.select_form_server') }}</a>
            </div>
            {{ Form::number('status', '5', ['readonly' => 'true', 'style' => 'display: none']) }}

            <hr>
            <h2 class="width">{{ Lang::get('messages.english') }}</h2>
            <p>{{ Lang::get('messages.name') }}</p>
            {{ Form::text('enName', isset($page->enName) ? $page->enName : '') }}

            <a id="back" href="{{ env('APP_URL') . str_replace(isset($article->name) ? '/articles' : '/audio', '', isset($article->name) ? str_replace('/' . $article->id . '/edit', '', $_SERVER['REQUEST_URI']) : str_replace('/create', '', $_SERVER['REQUEST_URI'])) }}"><span>{{ Lang::get('messages.backward') }}</span></a>
            {!! Form::submit(Lang::get('messages.save')); !!}
            {!! Form::close() !!}
        </div>
    </main>
    <script>
        var editor = CKEDITOR.replace( 'editor1',{
             filebrowserBrowseUrl : '/elfinder/ckeditor' 
        } );
        function elFinderBrowser (field_name, url, type, win) {
        tinymce.activeEditor.windowManager.open({
            file: '<?= route('elfinder.tinymce4') ?>',// use an absolute path!
            title: 'elFinder 2.0',
            width: 900,
            height: 450,
            resizable: 'yes'
        }, {
            setUrl: function (url) {
            win.document.getElementById(field_name).value = url;
            }
        });
        return false;
        }
    </script>

@endsection
