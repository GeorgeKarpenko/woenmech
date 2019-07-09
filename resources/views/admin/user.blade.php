@extends('admin.layouts.app')

@section('title')
<title>User: $user->name</title>
@endsection

@section('main')
    <main>
        <h1>{{ $user->name }}</h1>
        <div>
            {!! \App::isLocale('en') ?
            Form::open(['url' => route('en.admin.users.update', ['id'=> $user->id]),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
            :
            Form::open(['url' => route('admin.users.update', ['id'=> $user->id]),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}
            
            <div class="width">
            <p>{{ Lang::get('messages.status') }}</p>
            {{ Form::select('role', $mRoles, $user->role) }}
            </div>
            <a id="back" href="{{ \App::isLocale('en') ? route('en.admin.roles.index') : route('admin.roles.index') }}"><span>{{ Lang::get('messages.backward') }}</span></a>
            {!! Form::submit(Lang::get('messages.save')); !!}
            {!! Form::close() !!}
        </div>
    </main>

@endsection
