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
    <main class=" d-flex align-items-center justify-content-center" style="height: 100vh; background-color: #006769;">
        <div class="card shadow-lg col-12 col-md-10 col-lg-8 col-xl-6"
            style="border-radius: 10px; background-color: #fff7f2;">
            <div class="card-header text-center"
                style="background-color: #fff7f2; color: black; font-weight: bold; font-size: 1.5rem;">
                Reset TicketEase Account Password
            </div>

            <div class="card-body">
                <p class="text-center mb-4">
                    Please use a NEW password! For best account security, please do not re-use old passwords.
                </p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
                                autofocus placeholder="Account Email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password" placeholder="New Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-center">
                        <div class="col-md-8">
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Re-Type New Password">
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-8 text-center">
                            <button type="submit" class="btn btn-primary"
                                style="background-color: #006769; border: none;">
                                Set New Password <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-4">
                    <h5 class="text-center" style="color: black;">Secure password tips:</h5>
                    <ul style="list-style-type: none; padding: 0;">
                        <li><i class="fas fa-check-circle" style="color: black;"></i> Use numbers, letters, and only
                            these symbols: @ # ! $ % ^ & * : () - = + [] {} | ?</li>
                        <li><i class="fas fa-check-circle" style="color: black;"></i> Use a minimum of eight characters,
                            alphanumeric, and case-sensitive.</li>
                        <li><i class="fas fa-check-circle" style="color: black;"></i> Use a different password for each
                            website or application.</li>
                        <li><i class="fas fa-check-circle" style="color: black;"></i> Do not share your password with
                            others.</li>
                        <li><i class="fas fa-check-circle" style="color: black;"></i> Avoid using the same password from
                            compromised accounts.</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
</body>

</html>