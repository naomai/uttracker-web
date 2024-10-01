<!DOCTYPE HTML>
<html lang='en'>
<head>
<meta charset='utf-8'/>
<meta name='description' content="" />
@vite(['resources/sass/app.scss'])
@vite(['resources/js/app.js'])
<link rel="shortcut icon" type='image/png' href='{{asset('assets/uttfavRemixed.png')}}' />
<link rel='stylesheet' href='{{asset('css/app.css')}}'/>
<title>
@if(View::hasSection('title')) @yield('title') - @endif
{{ config('app.name', 'Laravel') }}
</title>
</head>
<body class="" id='ut_tracker_app'>
	<div id='logo_container'>
	    <h1 class='logo'><a href='/'>Unreal Tournament 99 Stats Tracker</a></h1>
	</div>
	
<div id='content'>
@yield("content")
</div>
</body>
</html>
