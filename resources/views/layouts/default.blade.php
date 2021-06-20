<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
	<title>{{ $title }}</title>
</head>

<body class="bg-gray-100">
	@yield('content')
</body>

</html>
