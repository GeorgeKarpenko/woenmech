@extends('admin.layouts.app')

@section('title')
<title>{{ Lang::get('messages.title') }}</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection

@section('main')
    <nav class="box-shadow">
        <div>
        {!! \App::isLocale('en') ?
            Form::open(['url' => route('en.admin.roles.update'),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data'])
            :
            Form::open(['url' => route('admin.roles.update'),
            'class'=>'contact-form wrapper_form','method'=>'POST','enctype'=>'multipart/form-data']) !!}

            <table class="sortable-table">
                <thead>
                    <tr>
                        <th>{{ Lang::get('messages.roles') }}</th>
                        @foreach($permissions as $permission)
                            <td>{{ App::isLocale('en') ? $permission->slug : $permission->name }}</td>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <th>
                                {{ $role->name }}
                            </th>
                            @foreach($permissions as $permission)
                                <td>
                                    @if($role->permissions()->where('name', '=' , $permission->name)->first())
                                    {!! Form::checkbox("roles[$role->id][$permission->id]", '', true) !!}
                                    @else
                                    {{ Form::checkbox("roles[$role->id][$permission->id]", '', false) }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody> 
            </table>

            {!! Form::submit(Lang::get('messages.save_roles')); !!}
            {!! Form::close() !!}

            <table class="sortable-table">
                <thead>
                    <tr>
                        <th>{{ Lang::get('messages.users') }}</th>
                        <td>{{ Lang::get('messages.status') }}</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th>
                                {{ $user->name }}
                            </th>
                            <td>
                            
                            @foreach($roles as $role)
                                @if ($user->hasRole(strtolower($role->name)))
                                    {{ $role->name }} 
                                @endif
                            @endforeach
                            </td>
                            <td>
                                <a href="{{ \App::isLocale('en') ? route('en.admin.users.edit', $user) : route('admin.users.edit', $user) }}">{{ Lang::get('messages.edit') }}</a>
                                <a href="{{ \App::isLocale('en') ? route('en.admin.users.delete', $user) : route('admin.users.delete', $user) }}">{{ Lang::get('messages.remove') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody> 
            </table>
        </div>
    </nav>
    <main>
</main>
@endsection
