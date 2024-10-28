<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'public/css/styles.css'])

</head>

<body>
    <main class="bg-logo-dark d-flex align-items-center justify-content-center" style="height: 100vh; width: 100wh;">
        <div class="card shadow-sm col-11 col-sm-10 col-md-9 col-lg-8 col-xl-7">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="row">
                    <div class="d-none col-lg-6 d-lg-flex flex-column align-items-center justify-content-center">
                        <h2 class="fw-bold text-logo-dark mb-3">CHO: TMS</h2>
                        <img src="{{ asset('img/cho.png') }}" alt="cho_logo" class="img-fluid">
                    </div>
                    <div class="col-12 col-md-8 col-lg-6 p-5 mx-auto d-flex flex-column align-items-center">
                        <div class="d-flex align-items-center mb-4">
                            <img src="{{ asset('img/logo.png') }}" alt="ticketease_logo" style="width: 60px;">
                            <h2 class="fw-bold text-dark mt-1">Ticket<span class="text-logo-dark">Ease</span></h2>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="username" class="text-logo-dark fw-semibold">Username</label>
                            <input id="username" name="username" type="text"
                                class="form-control @error('username') is-invalid @enderror border border-secondary"
                                required autocomplete="username" autofocus>
                            @error('username')
                            <x-error-message>{{ $message }}</x-error-message>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="password" class="text-logo-dark fw-semibold">Password</label>
                            <input id="password" name="password" type="password"
                                class="form-control @error('password') is-invalid @enderror border border-secondary"
                                required autocomplete="current-password">
                        </div>
                        <div class="col-12 text-end mb-3">
                            <a href="{{ route('password.request') }}" class="text-secondary text-sm">Forgot
                                password?</a>
                        </div>
                        <div class="col-12">
                            <x-submit-button class="form-control">LOGIN</x-submit-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
    @include('sweetalert::alert')
</body>

</html>