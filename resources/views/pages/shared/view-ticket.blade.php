@extends('layouts.master')
@section('title', 'TicketEase | Ticket')
@section('nav-title', 'Ticket Details')
@section('content')
<div class="tickets-wrapper">
    <button class="sliding-panel-toggle" type="button" style="z-index: 2;">
        <span class="material-icons sp-icon-open"><i class="fi fi-ss-angle-circle-left"></i></span>
        <span class="material-icons sp-icon-close"><i class="fi fi-ss-angle-circle-right"></i></span>
        <small class=" d-none d-md-block fw-semibold mb-1 ms-2">TICKET LOGS</small>
    </button>
    <div class="sliding-panel">
        <div class="tickets-container p-3">
            @foreach ($ticketAuditLogs as $log)
            <div class="col-12 mb-3">
                <div class="card bg-white">
                    <div class="card-header">
                        <span class="fw-bold">{{ $log->activity }}</span>
                    </div>
                    <div class="card-body py-2 px-3">
                        <small>
                            From <strong>{{ $log->previousStatus->status_name }}</strong>
                            To <strong>{{ $log->newStatus->status_name }}</strong>
                        </small>
                    </div>
                    <div class="card-footer">
                        <small>Performed at: <br><strong>{{ $log->created_at->format('F j, Y g:i a') }}</strong></small>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row p-4">
    <div class="col-12">
        <div class="card shadow-sm px-5 py-4 bg-white">
            <div class="col-12 d-flex justify-content-between gap-2">
                <h5 class="fw-semibold mt-2"><i class="fi fi-rr-user"></i>
                    Requestor Details
                </h5>
                <a href="{{ route($previousRoute) }}" class="btn btn-dark float-end fw-semibold">Go
                    Back</a>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="requestor" id="requestor_name" label="REQUESTOR"
                        value="{{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="ticket_id" id="ticket_number" label="TICKET ID"
                        value="{{ $ticket->id }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="email" id="email" label="EMAIL"
                        value="{{ $ticket->requestor->email }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="phone_number" id="phone_number" label="CONTACT NUMBER"
                        value="{{ $ticket->requestor->contact_number }}" />
                </div>
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="created_at" id="created_at" label="DATE SUBMITTED"
                        value="{{ \Carbon\Carbon::parse($ticket->created_at)->format('F j, Y g:i a') }}" />
                </div>
                @if ($ticket->date_assigned != NULL)
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="date_assigned" id="date_assigned" label="DATE ASSSIGNED"
                        value="{{ \Carbon\Carbon::parse($ticket->ticketAssign->created_at)->format('F j, Y g:i a') }}" />
                </div>
                @endif
            </div>
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
                    'For Waste' => 'warning',
                    'Invalid' => 'danger',
                    'Closed' => 'success'
                    };
                    @endphp
                    <small class="fw-semibold">Status:</small>
                    <x-user-role :color="$color">
                        <span class="px-3">
                            {{ strtoupper($ticket->status->status_name) }}
                        </span>
                    </x-user-role>
                </div>
            </div>
            <hr>
            <div class="row mt-2">
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
                <h5 class="fw-semibold mt-2"><i class="fi fi-rr-user"></i> Service Details</h5>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="technician" id="technician_name" label="TECHNICIAN"
                        value="{{ $ticket->ticketAssign->technician->firstname . ' ' . $ticket->ticketAssign->technician->lastname }}" />
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
                <div class="col-12 d-flex justify-content-end gap-3 mt-2">
                    <button class="btn btn-info fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#downloadServiceReport">
                        <i class="fi fi-ss-down-to-line me-1"></i>DOWNLOAD SERVICE REPORT
                    </button>
                    <button class="btn btn-primary fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#confirmGenerateReport">
                        <i class="fi fi-ss-file-medical-alt me-1"></i>GENERATE SERVICE REPORT
                    </button>
                </div>
            </div>
            <hr>
            @endif
        </div>
    </div>
</div>
@include('pages.shared.modals.report.generate-service-report')
@include('pages.shared.modals.report.download-service-report')
<script>
    document.querySelector(".sliding-panel-toggle").addEventListener("click", () => {
            document.querySelector(".tickets-wrapper").classList.toggle("sliding-panel-open");
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the previous route from the Blade view
        var previousRoute = @json($previousRoute);
        // Select all sidebar links
        var sidebarLinks = document.querySelectorAll('.sidebar-link');
        // Loop through each link
        sidebarLinks.forEach(function(link) {
        // Check if the link's ID matches the previous route
        if (link.id === previousRoute) {
        // Add the active class to the matching link
        link.classList.add('active');
        }
        });
    });
</script>
@endsection