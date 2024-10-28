@extends('layouts.master')
@section('title', 'TicketEase | Walk in')
@section('nav-title', 'Walk in')
@section('content')
<div class="p-4">
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-logo-dark">
                <h5 class="text-white fw-bold">
                    CHO ICT DEPARTMENT TICKET REQUEST FORM
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('ticket.store') }}" method="POST" autocomplete="off">
                    @csrf
                    @method('post')
                    <div class="row">
                        {{-- Requestor ID Input --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-input type="number" name="requestor_id" label="Requestor ID:"
                                placeholder="Enter requestor ID" arialabel="Enter Requestor ID" />
                        </div>

                        {{-- Ticket Nature Select --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-select :items="$ticketNatures" name="ticket_nature_id" label="Ticket Nature:"
                                selected="Select ticket nature" render="ticket_nature_name" />
                        </div>

                        {{-- District Select --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-select :items="$districts" name="district_id" label="District:"
                                selected="Select your district" render="district_name" />
                        </div>

                        {{-- Department Input --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-input type="text" name="department" label="Department:" placeholder="Enter department"
                                arialabel="Enter Department" />
                        </div>

                        {{-- Device Select --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-select :items="$devices" name="device_id" label="Device:" selected="Select your device"
                                render="device_name" />
                        </div>

                        {{-- Brand Input --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-input type="text" name="brand" label="Brand:" placeholder="Enter device brand"
                                arialabel="Enter Brand" />
                        </div>

                        {{-- Model Input --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-input type="text" name="model" label="Model:" placeholder="Enter device model"
                                arialabel="Enter Model" />
                        </div>

                        {{-- Property Number Input --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-input type="text" name="property_no" label="Property Number:"
                                placeholder="Enter property number" arialabel="Enter Property Number" />
                        </div>

                        {{-- Serial Number Input --}}
                        <div class="col-12 col-md-6 col-lg-4">
                            <x-input type="text" name="serial_no" label="Serial Number:"
                                placeholder="Enter serial number" arialabel="Enter Serial Number" />
                        </div>

                        {{-- Details Textarea --}}
                        <div class="col-12">
                            <x-textarea name="details" label="Details:" placeholder="Please enter additional details"
                                rows="2" />
                        </div>

                        {{-- Submit Button --}}
                        <div class="d-flex justify-content-end mt-2">
                            <x-submit-button><i class="fi fi-ss-paper-plane me-2"></i>Submit Ticket Request
                            </x-submit-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@vite(['resources/js/cus/ticketSubmissionForDevice.js'])
@endsection