@extends('layouts.app')

@section('title')
<title>{{ Lang::get('messages.title') }}</title>
@endsection

@section('header')
<p>{{ Lang::get('messages.header') }}</p>
@endsection

@section('main')
    <aside>
        {!! $nav->asUl() !!}
        @include('layouts.slogan')
    </aside>
    <main id="index">
        <img align="middle" src="{{ asset(env('THEME')) }}/img/sssr2.jpg">
        <p id="center">{!! Lang::get('messages.index') !!}
        </p>
        
    </main>
@endsection
