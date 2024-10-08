<!DOCTYPE HTML>
<html lang='en'>
<head>
<meta charset='utf-8'/>
<title>
	@if(View::hasSection('title')) @yield('title') - @endif
	{{ config('app.name', 'Laravel') }}
</title>
<meta name='description' content="" />
<link rel="shortcut icon" type='image/png' href='{{asset('assets/uttfavRemixed.png')}}' />
@stack("script-defs")
@vite(['resources/sass/app.scss'])
@vite(['resources/js/app.js'])
<link rel='stylesheet' href='{{asset('css/app.css')}}'/>

</head>
<body class="" id='ut_tracker_app'>
	<div id='logo_container'>
	    <h1 class='logo'><a href='/'>Server monitor</a></h1>
	</div>
	
<div id='content'>
@yield("content")
</div>
</body>
</html>
