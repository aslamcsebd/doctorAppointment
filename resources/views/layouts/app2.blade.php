<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('includes.head')
	  <link rel="stylesheet" href="{{ asset('css/authStyle.css') }}">
   </head>
   <body class="hold-transition sidebar-mini layout-fixed">
         @yield('content')
      @include('includes.modal')     
   </body>
</html>