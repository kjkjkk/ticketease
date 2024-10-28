@extends('layouts.master')
@section('title', 'TicketEase | Profile Setup')
@section('content')
<div class="p-5">
    <div class="d-flex align-items-center justify-content-center h-100 w-100">
        <div class="card shadow-sm col-11 col-sm-10 col-md-9 col-lg-8 col-xl-5">
            <div class="card-body">
                <div class="p-3">
                    <h4 class="card-title">Finish setting up your profile</h4>
                    <p class="card-text" style="color: gray;">We’re almost there! Just a few more details to finalize
                        your
                        profile.</p>
                </div>

                <form action="{{ route('profile-setup.store') }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="id" value="{{ Auth::id() }}">
                    <div class="row p-3">
                        <div class="col mx-auto">
                            <x-input name="email" label="Email Address" type="email" placeholder="Enter your email address"
                                arialabel="Email Address" :value="old('email')" />

                            <x-input name="contact_number" label="Contact Number" type="text"
                                placeholder="Enter your contact number" arialabel="Contact Number" :value="old('contact_number')" />
                        </div>
                    </div>

                    <div class="float-end p-3">
                        <x-submit-button>Next</x-submit-button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection