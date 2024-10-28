@extends('layouts.master')
@section('title', 'TicketEase | Ticket')
@section('nav-title', 'Ticket Details')
@section('content')
<div class="tickets-wrapper">
    <button class="sliding-panel-toggle" type="button" style="z-index: 2;">
        <span class="material-icons sp-icon-open"><i class="fi fi-ss-angle-circle-left"></i></span>
        <span class="material-icons sp-icon-close"><i class="fi fi-ss-angle-circle-right"></i></span>
        <small class="d-none d-md-block fw-semibold mb-1 ms-2">TICKET LOGS</small>
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
                <h5 class="fw-semibold mt-2"><i class="fi fi-rr-user"></i> Requestor Details</h5>
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
                        value="{{ $ticket->created_at->format('F j, Y g:i a') }}" />
                </div>
                @if ($ticket->ticketAssign)
                <div class="col-12 col-md-6">
                    <x-view-input type="text" name="created_at" id="created_at" label="DATE ASSSIGNED"
                        value="{{ $ticket->ticketAssign->created_at->format('F j, Y g:i a') }}" />
                </div>
                @endif
            </div>
            <hr>
            @include('pages.shared.ticket.view-update')
            <hr>
            <div class="row">
                {{-- Check if the ticket service is already rendered --}}
                @if($ticket->status_id == 3 && $ticket->ticketAssign->technician_id == Auth::id() &&
                ($ticket->ticketAssign->service_details === Null && $ticket->ticketAssign->service_rendered === Null))
                <div class="col-4">
                    <button class="btn btn-primary fw-semibold" data-bs-toggle="modal"
                        data-bs-target="#renderService"><i class="fi fi-ss-tools me-2"></i>Render Service</button>
                </div>
                @elseif ($ticket->status_id >= 3 && $ticket->ticketAssign->technician_id == Auth::id())
                {{-- Dislays service details --}}
                <div class="col-12 col-lg-6">
                    <div class="col-12 d-flex justify-content-between gap-2 mb-3">
                        <h5 class="fw-semibold mt-2">Ticket Service</h5>
                        <div>
                            <input type="checkbox" class="btn-check" id="checkboxServiceDetails" autocomplete="off">
                            <label class="btn btn-outline-primary fw-semibold" for="checkboxServiceDetails"><i
                                    class="fi fi-ss-customize-edit"></i>
                                Edit Service Details</label>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <form action="{{ route('shared.render-service') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="ticketID" value="{{ $ticket->id }}">
                            <input type="hidden" name="statusID" value="{{ $ticket->status_id }}">
                            <div class="col-12">
                                <x-view-textarea name="issueFound" id="issueFound" label="ISSUE FOUND" rows="2"
                                    value="{{ $ticket->ticketAssign->issue_found }}" />
                                @error('issueFound')
                                <x-error-message>{{ $message }}</x-error-message>
                                @enderror
                            </div>
                            <div class="col-12">
                                <x-view-textarea name="serviceRendered" id="serviceRendered" label="SERVICE RENDERED"
                                    rows="2" value="{{ $ticket->ticketAssign->service_rendered }}" />
                                @error('serviceRendered')
                                <x-error-message>{{ $message }}</x-error-message>
                                @enderror
                            </div>

                            <div class="col-12">
                                <div class="d-none float-end my-2" id="serviceDetailsButtonContainer">
                                    <x-submit-button><i class="fi fi-ss-disk me-2"></i>SAVE CHANGES</x-submit-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="col-12 px-3">
                        <div class="col-12 mb-3 rounded d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold">
                                Ticket status:
                                <span class="text-indi">
                                    {{ strtoupper($ticket->status->status_name) }}
                                </span>
                            </h6>
                            {{-- data-bs-toggle="modal" data-bs-target="#toggleDevice" --}}
                            <button class="btn btn-success fw-semibold" data-bs-toggle="modal"
                                data-bs-target="#updateTicketStatus">
                                <i class="fi fi-ss-convert-shapes me-2"></i>Update status
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="col-12 d-flex mb-3">
                        <h5 class="fw-semibold mt-2">Service Report</h5>
                    </div>
                    <div class="row mt-2">
                        @livewire('service-status', ['ticketAssignId' => $ticket->ticketAssign->id])
                        <div class="col-12 d-flex justify-content-between gap-3 mt-2">
                            <p>
                                <button class="btn btn-info fw-semibold" data-bs-toggle="modal"
                                    data-bs-target="#downloadServiceReport">
                                    <i class="fi fi-ss-down-to-line me-1"></i>DOWNLOAD SERVICE REPORT
                                </button>
                            </p>
                            <p>
                                <button class="btn btn-primary fw-semibold" data-bs-toggle="modal"
                                    data-bs-target="#confirmGenerateReport">
                                    <i class="fi fi-ss-file-medical-alt me-1"></i>GENERATE SERVICE REPORT
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                @if($ticket->status_id != 2 && $ticket->ticketAssign && $ticket->ticketAssign->technician_id ==
                Auth::id())
                <div class="col-12 mt-2">
                    <button class="btn btn-danger fw-semibold" data-bs-toggle="modal" data-bs-target="#invalid">
                        <i class="fi fi-ss-folder-xmark me-1"></i>Invalid
                    </button>
                    @if($ticket->status_id != 6)
                    <button class="btn btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#toCitc"><i
                            class="fi fi-ss-customize me-1"></i>To CITC</button>
                    @endif
                    <button class="btn btn-danger fw-semibold" data-bs-toggle="modal" data-bs-target="#toWaste"><i
                            class="fi fi-ss-recycle-bin me-1"></i>For
                        Waste</button>

                    @if($ticket->ticketAssign)
                    <button class="btn btn-success fw-semibold" data-bs-toggle="modal" data-bs-target="#closeTicket"><i
                            class="fi fi-ss-padlock-check me-1"></i>Close
                        Ticket</button>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('pages.shared.modals.render-service')
@include('pages.shared.modals.update-status')
@include('pages.shared.modals.invalid')
@include('pages.shared.modals.close-ticket')
@include('pages.shared.modals.to-citc')
@include('pages.shared.modals.for-waste')
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
        // Toggle edit for ticket details
        const checkboxTicketDetails = document.getElementById('checkboxTicketDetails');
        const ticketDetailsButtonContainer = document.getElementById('ticketDetailsButtonContainer');
        const ticketDetailsInputs = document.querySelectorAll('#editTicketNature, #editDistrict, #editDepartment, #editDevice, #editBrand, #editModel, #editPropertyNo, #editSerialNo, #editDetails');
        
        // Store initial values
        const ticketDetailsInitialValues = {};
        ticketDetailsInputs.forEach(input => {
            ticketDetailsInitialValues[input.id] = input.value;
        });

        checkboxTicketDetails.addEventListener('change', function () {
            const isEditing = this.checked;
            
            // Toggle button visibility
            ticketDetailsButtonContainer.classList.toggle('d-none', !isEditing);

            // Enable or disable input fields and revert values if not editing
            ticketDetailsInputs.forEach(input => {
                if (isEditing) {
                    input.disabled = false;
                } else {
                    input.disabled = true;
                    input.value = ticketDetailsInitialValues[input.id]; // Revert to initial value
                }
            });
        });

        // Toggle edit for service details
        const checkboxServiceDetails = document.getElementById('checkboxServiceDetails');
        const serviceDetailsButtonContainer = document.getElementById('serviceDetailsButtonContainer');
        const serviceDetailsInputs = document.querySelectorAll('#issueFound, #serviceRendered');
        
        // Store initial values
        const serviceDetailsIntitialValues = {};
        serviceDetailsInputs.forEach(input => {
            serviceDetailsIntitialValues[input.id] = input.value;
        });

        checkboxServiceDetails.addEventListener('change', function () {
            const isEditing = this.checked;
            
            // Toggle button visibility
            serviceDetailsButtonContainer.classList.toggle('d-none', !isEditing);

            // Enable or disable input fields and revert values if not editing
            serviceDetailsInputs.forEach(input => {
                if (isEditing) {
                    input.disabled = false;
                } else {
                    input.disabled = true;
                    input.value = serviceDetailsIntitialValues[input.id]; // Revert to initial value
                }
            });
        });
    });
</script>
@endsection