<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="UTF-8">

	<title>@yield('title')</title>

	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/bootstrap-colorpicker.min.css') }}">

	<script src="{{ asset('js/jquery.min.js') }}"></script>
	{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> --}}
	<script src="{{ asset('js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
	<script src="{{ asset('js/locale-all.js') }}"></script>
	<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap-colorpicker.min.js') }}"></script>
	{{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	
	


</head>

<body>
	@if( !Request::is('login') )
		@include('layouts.navbar')
	@endif
	
	<div class="container"  style="margin-top: 5rem;">
		@yield('content')
	</div>
	<script src="{{ asset('js/axios/axios.min.js') }}"></script>
	{{-- <script src="{{ asset('js/vuejs/vue.js') }}"></script> --}}
	@stack('scripts')
</body>
</html>