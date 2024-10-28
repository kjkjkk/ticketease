<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    {{-- Scripts --}}
    @vite(['resources/js/app.js', 'resources/css/app.css', 'public/css/styles.css' ])
    {{-- Chart.js --}}
    <script src='/js/dependencies/chart.js'></script>
    {{-- Icon --}}

    <link rel="stylesheet" href="{{ asset('css/uicons-solid-straight.css') }}">
    {{-- ToastR CSS --}}

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    {{-- Jquery --}}
    <script src='/js/dependencies/jquery.min.js'></script>
    <script src='/js/dependencies/moment.min.js'></script>
    {{-- ToastR JS --}}
    <script src='/js/dependencies/toastr.min.js'></script>
    {{-- Pusher --}}
    <script src='/js/dependencies/pusher.min.js'></script>
    <script>
        // ------ADDDEDDD------
        var hasOpenedModal = localStorage.getItem('modalOpened') || false;
        function resetModalFlag() {
            localStorage.removeItem('modalOpened'); 
        }
        // // ------ADDDEDDD------
        // Pusher.logToConsole = true;
            var pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
                authEndpoint: '/broadcasting/auth',
                auth: {
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    }
                }
            });
    </script>
    @livewireStyles
</head>
@if (auth()->user()->role === "Admin")
{{-- Include channels that are for admins only --}}
@include('layouts.broadcast.admin')
@elseif(auth()->user()->role === "Technician")
@include('layouts.broadcast.technician')
{{-- Include channels that are for technicians only --}}
@elseif(auth()->user()->role === "Requestor")
{{-- Include channels that are for requestors only --}}
@include('layouts.broadcast.requestor')
@endif

<body>
    <div class="wrapper">
        {{-- YIELD SIDEBAR --}}
        @if(Auth::user()->role == 'Admin')
        @include('partials.sidebar-admin')
        @elseif (Auth::user()->role == 'Technician')
        @include('partials.sidebar-technicain')
        @endif
        <div class="main">
            {{-- INCLUDE NAVBAR --}}
            @if (Auth::user()->role == "Admin" || Auth::user()->role == "Technician")
            @include('partials.navbar')
            @elseif (Auth::user()->role == "Requestor")
            @include('partials.requestor-nav')
            @endif
            {{-- CONTENT GOES HERE --}}
            <main class="content">
                @yield('content')
            </main>
            {{-- INCLUDE FOOTER --}}
            @include('partials.footer')
            <div class="overlay"></div>
        </div>
    </div>
    {{--Notification Scripts --}}
    @if (Auth::user()->role == "Admin" || Auth::user()->role == "Technician")
    @include('partials.notifications')
    @vite(['resources/js/cus/template.js'])
    {{-- <script src="{{ asset('js/template.js') }}"></script> --}}
    @endif
    @vite(['resources/js/cus/recycable.js'])
    {{-- <script src="{{ asset('js/recycable.js') }}"></script> --}}
    @include('sweetalert::alert')
    <!--<script src='/public/vendor/livewire/livewire.js'></script>-->

</body>

</html>