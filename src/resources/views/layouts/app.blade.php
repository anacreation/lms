<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Easy LMS') }}</title>
	
	<!-- Styles -->
    <link href="{{ asset('css/vendor/lms/app.css') }}" rel="stylesheet">
	
	@stack('styles')
</head>
<body>
    <div id="app" class="wrapper">
	    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
	         <div class="container">
		         <a class="navbar-brand" href="{{ url('/home') }}">
		         {{ config('app.name', 'Easy LMS') }}
		         </a>
		         <button class="navbar-toggler" type="button"
		                 data-toggle="collapse"
		                 data-target="#navbarSupportedContent"
		                 aria-controls="navbarSupportedContent"
		                 aria-expanded="false" aria-label="Toggle navigation">
		         <span class="navbar-toggler-icon"></span>
		         </button>
		         
		         <div class="collapse navbar-collapse"
		              id="navbarSupportedContent">
			         
		             @include("lms::layouts.partials.leftNavbar")
			
			         @include("lms::layouts.partials.rightNavbar")
		         </div>
	         </div>
         </nav>
	    <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{asset('js/vendor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{ asset('js/vendor/lms/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor/lms.js') }}"></script>
    <script src="{{ asset('js/vendor/lms/app.js') }}"></script>s
</body>
</html>
