<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    {{-- Scripts --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <!-- <link rel="stylesheet" href="css/font-awesome.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
    <main class=" d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #006769; ">
        <div class="card shadow col-11 col-sm-10 col-md-9 col-lg-8 col-xl-7"
            style="border-radius: 10px; background-color: #ffffff; border: none;">
            <div class="card-header text-center"
                style="background-color: #ffffff; color: white; font-weight: bold; font-size: 1.5rem; color: black;">
                Forgot TicketEase Password?
            </div>

            <div class="card-body">
                <p class="text-center mb-4">
                    Enter the email address you registered for your TicketEase account, and we will send you an email
                    message with password reset information.
                </p>

                @if (session('status'))
                <div class="alert alert-success text-center" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="row justify-content-center mb-3">
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" placeholder="youremail@somewhere.com" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center mb-4">
                        <div class="col-md-8 text-center">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #006769; border: none;">
                                Get My Account Information
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="btn btn-secondary"
                        style="background-color: #46AAAC;  border: none;">Back to Login</a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>