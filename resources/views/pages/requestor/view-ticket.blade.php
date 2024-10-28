@extends('layouts.master')
@section('title', 'TicketEase | Ticket')
@section('nav-title', 'Ticket Details')
@section('content')
<div class="row p-4">
    <div class="col-12">
        <div class="card shadow-sm px-5 py-4 bg-white">
            <div class="col-12 d-flex">
                <h5 class="fw-semibold mt-2"><i class="fi fi-rr-user"></i>
                    Ticket Status Progress
                </h5>
            </div>
            <hr>
            <x-requestor.status-progress :ticket="$ticket"></x-requestor.status-progress>
            <hr>
            <div class="col-12 d-flex justify-content-between gap-2">
                <h5 class="fw-semibold mt-2">
                    Ticket Details
                </h5>
                <div class="row">
                    @php
                    $color = match($ticket->status->status_name) {
                    'Unassigned' => 'danger',
                    'Assigned' => 'warning',
                    'In Progress' => 'primary',
                    'Repaired' => 'info',
                    'To CITC' => 'primary',
                    'For Release' => 'indi',
                    'For Waste' => 'warning',
                    'Invalid' => 'danger',
                    'Closed' => 'success'
                    };
                    @endphp
                    <small class="fw-semibold">Status:</small>
                    <x-user-role :color="$color">
                        <span class="px-3 text-uppercase">
                            {{ $ticket->status->status_name }}
                        </span>
                    </x-user-role>
                </div>
            </div>
            <hr>
            <div class="row mt-2">
                <input type="hidden" name="id" id="id" value="{{ $ticket->id }}">
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="ticket_id" id="ticket_id" label="TICKET ID"
                        value="{{ $ticket->id }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="ticket_nature" id="ticket_nature" label="TICKET NATURE"
                        value="{{ $ticket->ticketNature->ticket_nature_name }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="district" id="district" label="District"
                        value="{{ $ticket->district->district_name }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="department" id="Department" label="DEPARTMENT"
                        value="{{ $ticket->department }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="device" id="device" label="DEVICE"
                        value="{{ $ticket->device->device_name }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="brand" id="Brand" label="BRAND" value="{{ $ticket->brand }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="model" id="Model" label="MODEL" value="{{ $ticket->model }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="property_no" id="PropertyNo" label="PROPERTY NO."
                        value="{{ $ticket->property_no }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="serial_no" id="SerialNo" label="SERIAL NO."
                        value="{{ $ticket->serial_no }}" />
                </div>
                <div class="col-12">
                    <x-view-textarea name="details" id="Details" label="DETAILS" rows="2"
                        value="{{ $ticket->details }}" />
                </div>
            </div>
            <hr>
            @if($ticket->ticketAssign)
            <div class="col-12 d-flex justify-content-between gap-2">
                <h5 class="fw-semibold mt-2"><i class="fi fi-rr-user"></i>Technician & Service Details</h5>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="technician" id="technician_name" label="TECHNICIAN"
                        value="{{ $ticket->ticketAssign->technician->firstname . ' ' . $ticket->ticketAssign->technician->lastname }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="email" id="SerialNo" label="EMAIL"
                        value="{{ $ticket->ticketAssign->technician->email }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="contact_number" id="SerialNo" label="CONCTACT NUMBER"
                        value="{{ $ticket->ticketAssign->technician->contact_number }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="service_status" id="service_status" label="SERVICE STATUS"
                        value="{{ $ticket->ticketAssign->service_status }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-textarea name="service_rendered" id="service_rendered" label="SERVICE RENDERED" rows="2"
                        value="{{ $ticket->ticketAssign->service_rendered }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-textarea name="issue_found" id="issue_found" label="ISSUE FOUND" rows="2"
                        value="{{ $ticket->ticketAssign->issue_found }}" />
                </div>
            </div>
            <hr>
            @endif
        </div>
    </div>
</div>
@endsection