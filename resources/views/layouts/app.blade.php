
<!-- saved from url=(0018)http://warmech.ru/ -->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	@yield('title')
	<link href="{{ asset(env('THEME')) }}/css/all.css" rel="stylesheet" type="text/css">

	<link rel="stylesheet" href="{{ asset(env('THEME')) }}/css/style.css">
    <meta content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width">
</head>


<body>

<div class="id_body">
	<header>
		@include('layouts.slogan')
		<div class="toggle-button" onclick="myFunction(this)">
			<div class="bar1"></div>
			<div class="bar2"></div>
			<div class="bar3"></div>
		</div>
 		<div class="wrapper">
			 <div>
				<a href="{{ \App::isLocale('en') ? '/en' : '/' }}"><img src="{{ asset(env('THEME')) }}/img/{{ Lang::get('messages.logo') }}"></a>
				@yield('header')
				<div class="search-wrapper">
					{!! 
					\App::isLocale('en') ? 
					Form::open(['url' => route('en.search'),
					'class'=>'input-holder','method'=>'GET'])
					: 
					Form::open(['url' => route('search'),
					'class'=>'input-holder','method'=>'GET']) !!}
					{{ Form::text('query', null, array( 'placeholder' => Lang::get('messages.search_placeholder'), 'class'=>'search-input')) }}
					<button class="search-icon"><span></span></button>
					{{ Form::close() }}
				</div>
			</div>
			<a id="lang" href="{{ \App::isLocale('en') ? str_replace('/en', '', $_SERVER['REQUEST_URI']) ? str_replace('/en', '', $_SERVER['REQUEST_URI']) : '/' : '/en' . $_SERVER['REQUEST_URI'] }}">{{ \App::isLocale('en') ? 'ru' : 'en' }}</a>
		</div>
	</header>
	<div id = "content">
		<div class="wrapper">
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
</div>
<script>
	function myFunction(x) {
		x.classList.toggle("change");
		document.querySelector("aside").classList.toggle("nav-mobile");
	}
</script>
</body>
</html>