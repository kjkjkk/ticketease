@extends('layouts.master')
@section('title', 'TicketEase | Profile Setup')
@section('content')
<div class="p-5">
    <div class="d-flex align-items-center justify-content-center h-100 w-100">
        <div class="card shadow-sm col-11 col-sm-10 col-md-9 col-lg-8 col-xl-5">
            <div class="card-body">
                <div class="p-3">
                    <h4 class="card-title mb-3">Verify your email address</h4>
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request
                            another') }}</button>.
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection