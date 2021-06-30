<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <title>{{ $title }}</title>
</head>

<body class="bg-gradient-to-r from-blue-200 to-green-100 px-4">
    <nav class="fixed left-1/2 top-4 w-full max-w-2xl -translate-x-1/2 px-4">
        <div class="flex bg-white items-center justify-between rounded-xl py-4 px-4 md:px-8 shadow-lg">
            <a href="/" class="flex space-x-1 md:space-x-4 items-center text-xl font-extrabold text-teal-800 ">
                <img src="{{ asset('images/robort.png') }}" class="w-6">
                <h1 class="hidden md:block">Robort Arm System</h1>
                <h1 class="md:hidden">RAS</h1>
            </a>
            <div class="font-bold flex-none flex text-sm md:text-base space-x-8">
                <a href="/control-panel"
                    class="{{ URL::to('/control-panel') === url()->current() ? 'underline text-gray-900' : 'text-gray-700' }} hover:text-teal-800">Control
                    Panel</a>
                <a href="/result-panel"
                    class="{{ URL::to('/result-panel') === url()->current() ? 'underline text-gray-900' : 'text-gray-700' }} hover:text-teal-800">Result
                    Panel</a>
            </div>
        </div>
    </nav>
    @yield('content')
</body>

</html>
