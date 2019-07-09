@extends('admin.layouts.app')

@section('title')
<title>{{ isset($page->name) ? $page->name : Lang::get('messages.add_section') }}</title>
<link rel="stylesheet" type="text/css" href="/colorbox-master/example1/colorbox.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="{{ asset('/js/ckeditor_4.11.4_full/ckeditor.js') }}" type="text/javascript" charset="utf-8" ></script>
<script src="{{ asset('/colorbox-master/jquery.colorbox-min.js') }}" type="text/javascript" charset="utf-8" ></script>
<script type="text/javascript" src="/packages/barryvdh/elfinder/js/standalonepopup.min.js"></script>
@endsection

@section('main')
    @if($page->status == 0)
            <main>
                <div>
                    @if (isset($page->name)) 
                    {!! \App::isLocale('en') ?
                    Form::open(['url' => route('en.admin.pages.update', ['path' => $path, 'id'=> $page->id]),
                    'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
                    :
                    Form::open(['url' => route('admin.pages.update', ['path' => $path, 'id'=> $page->id]),
                    'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                    {!! \App::isLocale('en') ?
                    Form::open(['url' => route('en.admin.pages.make', $path),
                    'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data'])
                    :
                    Form::open(['url' => route('admin.pages.make', $path),
                    'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data']) !!}
                    @endif
                    <p>{{ Lang::get('messages.name') }}</p>
                    {{ Form::text('name', isset($page->name) ? $page->name : '') }}

                    <p>URL</p>
                    {{ Form::text('path', isset($page->path) ? $page->path : '') }}

                    <p>{{ Lang::get('messages.text') }}</p>
                    {{ Form::textarea('text', isset($page->text) ? $page->text : '', ['id' => "editor1"]) }}
                    {{ Form::number('status', '0', ['readonly' => 'true', 'style' => 'display: none']) }}

                    <hr>
                    <h2 class="width">{{ Lang::get('messages.english') }}</h2>
                    <p>{{ Lang::get('messages.name') }}</p>
                    {{ Form::text('enName', isset($page->enName) ? $page->enName : '') }}

                    <p>{{ Lang::get('messages.text') }}</p>
                    {{ Form::textarea('enText', isset($page->enText) ? $page->enText : '', ['id' => "editor2"]) }}

                    <a id="back" href="{{ env('APP_URL') . str_replace('/pages', '', isset($page->name) ? str_replace('/' . 'edit/' . $page->id, '', $_SERVER['REQUEST_URI']) : str_replace('/create/newWebPage/newWebPage', '', $_SERVER['REQUEST_URI'])) }}"><span>{{ Lang::get('messages.backward') }}</span></a>
                    {!! Form::submit(Lang::get('messages.save')) !!}
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
    @elseif($page->status == 2)
            <main>
                <div>
                    @if (isset($page->name)) 
                    {!! \App::isLocale('en') ?
                    Form::open(['url' => route('en.admin.pages.update', ['path' => $path, 'id'=> $page->id]),
                    'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
                    :
                    Form::open(['url' => route('admin.pages.update', ['path' => $path, 'id'=> $page->id]),
                    'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                    {!! \App::isLocale('en') ?
                    Form::open(['url' => route('en.admin.pages.make', $path),
                    'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data'])
                    :
                    Form::open(['url' => route('admin.pages.make', $path),
                    'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data']) !!}

                    @endif
                    <p>{{ Lang::get('messages.name') }}</p>
                    {{ Form::text('name', isset($page->name) ? $page->name : '') }}
                    <p>{{ Lang::get('messages.photo') }}</p>
                    <div>
                    {{ Form::text('img', isset($page->img) ? $page->img : '', ['id' => "img"]) }}
                    <a href="" class="popup_selector btn btn-primary" data-inputid="img">{{ Lang::get('messages.select_form_server') }}</a>
                    </div>
                    <p>{{ Lang::get('messages.text_to_photo') }}</p>
                    {{ Form::text('imgText', isset($page->imgText) ? $page->imgText : '') }}


                    <p>URL</p>
                    {{ Form::text('path', isset($page->path) ? $page->path : '') }}

                    
                    @for ($i = 0; $i < 3; $i++)
                        @if (isset($page->imgLeft[$i]))
                            <p>{{ Lang::get('messages.photos_to_the_left') }}</p>
                            <div>
                                {{ Form::text("imgLeft[]", $page->imgLeft[$i], ['id' => "imgLeft$i"]) }}
                                <a href="" class="popup_selector btn btn-primary" data-inputid="imgLeft{{ $i }}">{{ Lang::get('messages.select_form_server') }}</a>
                            </div>
                        @else
                            <p>{{ Lang::get('messages.photos_to_the_left') }}</p>
                            <div>
                                {{ Form::text("imgLeft[]", '', ['id' => "imgLeft$i"]) }}
                                <a href="" class="popup_selector btn btn-primary" data-inputid="imgLeft{{ $i }}">{{ Lang::get('messages.select_form_server') }}</a>
                            </div>
                        @endif
                    @endfor


                    @for ($i = 0; $i < 3; $i++)
                        @if (isset($page->imgRight[$i]))
                            <p>{{ Lang::get('messages.photos_to_the_right') }}</p>

                            <div>
                                {{ Form::text("imgRight[]", $page->imgRight[$i], ['id' => "imgRight$i"]) }}
                                <a href="" class="popup_selector btn btn-primary" data-inputid="imgRight{{ $i }}">{{ Lang::get('messages.select_form_server') }}</a>
                            </div>
                        @else

                            <p>{{ Lang::get('messages.photos_to_the_right') }}</p>

                            <div>
                                {{ Form::text("imgRight[]", '', ['id' => "imgRight$i"]) }}
                                <a href="" class="popup_selector btn btn-primary" data-inputid="imgRight{{ $i }}">{{ Lang::get('messages.select_form_server') }}</a>
                            </div>
                        @endif
                    @endfor

                    <p>{{ Lang::get('messages.text') }}</p>
                    {{ Form::textarea('text', isset($page->text) ? $page->text : '', ['id' => "editor1"]) }}
                    {{ Form::number('status', '2', ['readonly' => 'true', 'style' => 'display: none']) }}

                    
                    <hr>
                    <h2 class="width">{{ Lang::get('messages.english') }}</h2>
                    <p>{{ Lang::get('messages.name') }}</p>
                    {{ Form::text('enName', isset($page->enName) ? $page->enName : '') }}

                    <p>{{ Lang::get('messages.text_to_photo') }}</p>
                    {{ Form::text('enImgText', isset($page->enImgText) ? $page->enImgText : '') }}

                    <p>{{ Lang::get('messages.text') }}</p>
                    {{ Form::textarea('enText', isset($page->enText) ? $page->enText : '', ['id' => "editor2"]) }}

                    <a id="back" href="{{ env('APP_URL') . str_replace('/pages', '', isset($page->name) ? str_replace('/' . 'edit/' . $page->id, '', $_SERVER['REQUEST_URI']) : str_replace('/create/complexSection/complexSection', '', $_SERVER['REQUEST_URI'])) }}"><span>{{ Lang::get('messages.backward') }}</span></a>
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
    @else
            <main>
                <div>
                    @if (isset($page->name)) 
                    {!! \App::isLocale('en') ?
                    Form::open(['url' => route('en.admin.pages.update',['path' => $path, 'id'=> $page->id]),
                    'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
                    :
                    Form::open(['url' => route('admin.pages.update',['path' => $path, 'id'=> $page->id]),
                    'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                    {!! \App::isLocale('en') ?
                    Form::open(['url' => route('en.admin.pages.make', ['path' => $path]),
                    'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data'])
                    :
                    Form::open(['url' => route('admin.pages.make', ['path' => $path]),
                    'class'=>'contact-form wrapper_form','method'=>'POST ','enctype'=>'multipart/form-data']) !!}
                    @endif
                    <p>{{ Lang::get('messages.name') }}</p>
                    {{ Form::text('name', isset($page->name) ? $page->name : '') }}

                    <p>URL</p>
                    {{ Form::text('path', isset($page->path) ? $page->path : '') }}
                    {{ Form::number('status', '1', ['readonly' => 'true', 'style' => 'display: none']) }}
                    <hr>
                    <h2 class="width">{{ Lang::get('messages.english') }}</h2>
                    <p>{{ Lang::get('messages.name') }}</p>
                    {{ Form::text('enName', isset($page->enName) ? $page->enName : '') }}
                    <a id="back" href="{{ env('APP_URL') . str_replace('/pages', '', isset($page->name) ? str_replace('/' . 'edit/' . $page->id, '', $_SERVER['REQUEST_URI']) : str_replace('/create', '', $_SERVER['REQUEST_URI'])) }}"><span>{{ Lang::get('messages.backward') }}</span></a>
                    {!! Form::submit(Lang::get('messages.save')); !!}
                    {!! Form::close() !!}
                </div>
            </main>
    @endif
@endsection
