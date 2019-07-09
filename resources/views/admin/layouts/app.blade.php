
<!-- saved from url=(0018)http://warmech.ru/ -->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	@yield('title')
    <link href="{{ asset(env('THEME')) }}/css/bootstrap-4.0.0.css" rel="stylesheet" type="text/css">
    <link href="{{ asset(env('THEME')) }}/css/all.css" rel="stylesheet" type="text/css">
	<link href="{{ asset(env('THEME')) }}/css/admin.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="{{ asset(env('THEME')) }}/css/style.css">
    <meta content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width">
</head>


<body>

<div class="id_body">
	<header>
		@include('layouts.slogan')
		<!--
		<div class="toggle-button" onclick="myFunction(this)">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
		</div>
		-->
 		<div class="wrapper">
			 <div>
				<a href="{{ \App::isLocale('en') ? '/en/admin' : '/admin' }}"><img src="{{ asset(env('THEME')) }}/img/{{ Lang::get('messages.logo') }}"></a>
				@yield('header')
				<h4>{{ Auth::user()->name }}</h4>
				<p class="text-muted">{{ Auth::user()->email }}</p>
				<a href="{{ \App::isLocale('en') ? str_replace('/en', '', $_SERVER['REQUEST_URI']) ? str_replace('/en', '', $_SERVER['REQUEST_URI']) : '/' : '/en' . $_SERVER['REQUEST_URI'] }}">{{ \App::isLocale('en') ? 'ru' : 'en' }}</a>
				<br>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i>{{ Lang::get('messages.exit') }}</a>
			</div>
		</div>
	</header>
<div id = "content">
	@if (session('status'))
		<div class="alert alert-success" role="alert">
			{{ session('status') }}
		</div>
	@endif


	<div class="wrapper">
		@if ($errors->any())
			@foreach ($errors->all() as $error)
				<div class="alert alert-danger">
					{{ $error }}
				</div>
			@endforeach
		@endif
		@yield('main')
	</div>
</div>

<footer>
	<div class="wrapper">
		<div>
			<a href="mailto:piun_pv@mail.ru">Copyright © 2009</a>
			<p>{!! Lang::get('messages.footer') !!}</p>
		</div>
	</div>
</footer>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<!--
<script>
	function myFunction(x) {
		x.classList.toggle("change");
		document.querySelector("aside").classList.toggle("nav-mobile");
	}
</script>
-->
</body>
</html>