@extends('layouts.master')
@section('title', 'TicketEase | Profile')
@section('nav-title', 'Profile')
@section('content')
<div class="container-fluid p-4">
    <div class="card shadow-sm p-4">
        <div class="row h-100">
            <div class="col-12 col-xl-3">
                <ul class="settings d-flex flex-xl-column mt-4">
                    <li class="settings-nav active" id="personalInformation" onclick="toggleContainers('personal')">
                        Personal&nbsp;Information
                    </li>
                    <li class="settings-nav " id="changePassword" onclick="toggleContainers('password')">
                        Account&nbsp;Settings
                    </li>
                </ul>
            </div>
            <div class="col-12 col-xl-9 p-4" style="height: 100%; overflow-y: auto;">
                <div id="personal-information-container" class="d-block">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <h4 class="fw-bold text-logo-dark">Personal Information</h4>
                                <div>
                                    <input type="checkbox" class="btn-check" id="checkboxPersonalInformation"
                                        autocomplete="off">
                                    <label class="btn btn-sm btn-outline-primary fw-semibold"
                                        for="checkboxPersonalInformation"><i class="fi fi-ss-customize-edit"></i>
                                        Edit Personal Information</label>
                                </div>
                            </div>
                            <form action="{{ route('user.update-profile', auth()->user()->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="row my-3">
                                    <div class="col-12 col-md-6">
                                        <x-view-input type="text" name="firstname" id="editFirstname" label="FIRSTNAME"
                                            value="{{ auth()->user()->firstname}}" />
                                        @error('firstname')
                                        <x-error-message>{{ $message }}</x-error-message>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <x-view-input type="text" name="lastname" id="editLastname" label="LASTNAME"
                                            value="{{ auth()->user()->lastname}}" />
                                        @error('lastname')
                                        <x-error-message>{{ $message }}</x-error-message>
                                        @enderror
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <x-view-input type="text" name="contact_number" id="editContactNumber"
                                            label="CONTACT NUMBER" value="{{ auth()->user()->contact_number}}" />
                                        @error('contact_number')
                                        <x-error-message>{{ $message }}</x-error-message>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-none float-end my-2" id="personalInformationButtonContainer">
                                        <x-submit-button><i class="fi fi-ss-disk me-2"></i>SAVE CHANGES
                                        </x-submit-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-12 col-md-9 col-lg-6 mx-auto">
                            @if(auth()->user()->role !== 'Requestor')
                            <div class="d-flex">
                                <h6 class="fw-semibold text-dark">Technician Signature</h6>
                            </div>
                            <hr>
                            <div class="card rounded mb-3 w-75">
                                {{-- Display the image here using short if --}}
                                <img src="{{ auth()->user()->signature ? Storage::url(auth()->user()->signature) : asset('img/placeholder.png') }}"
                                    alt="signature" class="img-fluid h-100 w-100 rounded">
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-danger fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#removeSignature">
                                    Remove Signature
                                </button>
                                <button class="btn btn-primary fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#changeSignature">
                                    Change Signature
                                </button>
                            </div>
                            @endif
                        </div>
                        <!--  changing email      -->
                        @if (auth()->user()->email && auth()->user()->email_verified_at)
                        <div class="col-12 col-md-9 col-lg-6 mx-auto">
                            <div class=" d-flex">
                                <h6 class="fw-semibold text-dark">Email</h6>
                                @if(auth()->user()->hasVerifiedEmail())
                                <small class="text-success fw-bold ms-2">VERIFIED</small>
                                @endif
                            </div>
                            <x-view-input type="email" name="email" id="editEmail" label="CURRENT EMAIL"
                                value="{{ auth()->user()->email}}" />
                            <small class="fw-semibold">ENTER NEW EMAIL ADDRESS:</small>
                            <form action="{{ route('change-email', auth()->user()->id) }}" method="POST">
                                {{-- CHANGESSSSSSS --}}
                                @if (session()->has('email_faill') || session()->has('email_successs'))
                                <x-alert-message />
                                @endif
                                {{-- CHANGESSSSSSS --}}
                                @csrf
                                @method('PATCH')
                                <input type="text" name="new_email"
                                    class="form-control border-0 border-bottom border-secondary text-end">
                                {{-- CHANGESSSSSSS --}}
                                @error('new_email')
                                <small class="fw-semibold text-danger">{{ $message }}</small>
                                @enderror
                                {{-- CHANGESSSSSSS --}}
                                <div class="d-flex justify-content-end mt-3">
                                    <x-submit-button><i class="fi fi-ss-disk me-2"></i>Change email</x-submit-button>
                                </div>
                            </form>
                            <hr>
                        </div>
                        @endif
                    </div>
                </div>
                <div id="change-password-container" class="d-none">
                    @livewire('profile.change-password')
                </div>
            </div>

        </div>
    </div>
</div>
@include('pages.shared.modals.change-signature')
@include('pages.shared.modals.remove-signature')
<script>
    function toggleContainers(container) {
        const personalInformationClick = document.getElementById('personalInformation');
        const changePasswordClick = document.getElementById('changePassword');

        const personalInformationContainer = document.getElementById('personal-information-container');
        const changePasswordContainer = document.getElementById('change-password-container');
        
        if (container === 'personal') {
            // Toggle the container visibility
            personalInformationContainer.classList.remove('d-none');
            personalInformationContainer.classList.add('d-block');

            changePasswordContainer.classList.remove('d-block');
            changePasswordContainer.classList.add('d-none');
            // Toggle the list active class
            personalInformationClick.classList.add('active');
            changePasswordClick.classList.remove('active');
        } else if (container === 'password') {
            // Toggle the container visibility
            changePasswordContainer.classList.remove('d-none');
            changePasswordContainer.classList.add('d-block');

            personalInformationContainer.classList.remove('d-block');
            personalInformationContainer.classList.add('d-none');
            // Toggle the list active class
            changePasswordClick.classList.add('active');
            personalInformationClick.classList.remove('active');
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle edit for ticket details
        const checkboxPersonameInformation = document.getElementById('checkboxPersonalInformation');
        const personalInformationButtonContainer = document.getElementById('personalInformationButtonContainer');
        const personalInformationInputs = document.querySelectorAll('#editFirstname, #editLastname, #editUsername, #editContactNumber');
        
        // Store initial values
        const personalInformationInitialValues = {};
        personalInformationInputs.forEach(input => {
            personalInformationInitialValues[input.id] = input.value;
        });

        checkboxPersonameInformation.addEventListener('change', function () {
            const isEditing = this.checked;
            
            // Toggle button visibility
            personalInformationButtonContainer.classList.toggle('d-none', !isEditing);

            // Enable or disable input fields and revert values if not editing
            personalInformationInputs.forEach(input => {
                if (isEditing) {
                    input.disabled = false;
                } else {
                    input.disabled = true;
                    input.value = personalInformationInitialValues[input.id]; // Revert to initial value
                }
            });
        });

        
    });
</script>

@endsection