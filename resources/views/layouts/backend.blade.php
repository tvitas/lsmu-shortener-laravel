<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ __(config('app.name', 'Laravel')) }}</title>
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
@include('partials.navbar')
@yield('content')
@yield('modals')
@yield('offcanvas')
@include('partials.footer')
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
