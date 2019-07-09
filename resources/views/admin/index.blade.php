@extends('admin.layouts.app')

@section('title')
<title>Admin</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection

@section('main')
    <nav class="box-shadow">
        <div>
            <h1>{{ Lang::get('messages.main_page_menu') }}</h1>
            @if($nav)
            {!! Form::open(['url' => route('admin.pages.priority'),
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
                            @if($section->text)
                                <a href="{{ \App::isLocale('en') ? route('en.admin.pages.edit', ['page' => $section->id, 'path' => 'newWebPage', 'webPage' => 'newWebPage']) : route('admin.pages.edit', ['page' => $section->id, 'path' => 'newWebPage', 'webPage' => 'newWebPage']) }}">{{ Lang::get('messages.edit') }}</a>
                            @else
                                <a href="{{ \App::isLocale('en') ? route('en.admin.pages.edit', ['page' => $section->id]) : route('admin.pages.edit', ['page' => $section->id]) }}">{{ Lang::get('messages.edit') }}</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ \App::isLocale('en') ? route('en.admin.pages.delete', ['page' => $section->id]) : route('admin.pages.delete', ['page' => $section->id]) }}">{{ Lang::get('messages.remove') }}</a>
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
                <ul>
                    <li><a href="{{ \App::isLocale('en') ? route('en.admin.pages.create') :  route('admin.pages.create') }}">{{ Lang::get('messages.add_section') }}</a></li>
                    <li><a href="{{ \App::isLocale('en') ? route('en.admin.pages.create', ['path' => 'complexSection', 'webPage' => 'complexSection']) : route('admin.pages.create', ['path' => 'complexSection', 'webPage' => 'complexSection']) }}">{{ Lang::get('messages.add_complex_section') }}</a></li>
                    <li><a href="{{ \App::isLocale('en') ? route('en.admin.pages.create', ['path' => 'newWebPage', 'webPage' => 'newWebPage']) : route('admin.pages.create', ['path' => 'newWebPage', 'webPage' => 'newWebPage']) }}">{{ Lang::get('messages.add_page') }}</a></li>                
                    @role('admin')
                        <li><a href="{{ \App::isLocale('en') ? route('en.admin.roles.index') : route('admin.roles.index') }}">{{ Lang::get('messages.roles') }}</a></li>     
                    @endrole           
                </ul>
            </nav>
        </div>
    </nav>
@endsection