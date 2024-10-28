@extends('layouts.master')
@section('title', 'TicketEase | My Ticket')
@section('nav-title', 'My Tickets')
@section('content')
<div class="tickets-wrapper">
    <button class="sliding-panel-toggle" type="button" style="z-index: 2;">
        <span class="material-icons sp-icon-open"><i class="fi fi-ss-angle-circle-left"></i></span>
        <span class="material-icons sp-icon-close"><i class="fi fi-ss-angle-circle-right"></i></span>
        <small class="d-none d-md-block fw-semibold mb-1 ms-2">Reassign Requests <span
                class="bg-danger rounded-circle px-1 ">{{
                count($reassigns)
                }}</span></small>
    </button>
    <div class="sliding-panel">
        <div class="tickets-container mt-2 mb-2">
            <div class="">
                @forelse ($reassigns as $reassign)
                <div class="col">
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-white d-flex align-items-center">
                            <div class="circle-sm bg-light-subtle">
                                <i class="fi fi-ss-ticket mt-1"></i>
                            </div>
                            <small class="fw-semibold ms-2">Ticket No.</small>
                            <h6 class="font-weight-bold ms-2 mt-2">#{{ $reassign->ticket_id }}</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 d-flex mb-3">
                                    <x-user-box size="md">{{ substr($reassign->ticket->requestor->firstname, 0, 1)
                                        }}
                                    </x-user-box>
                                    <span class="d-flex flex-column ms-1">
                                        <span class="fw-semibold">
                                            {{ $reassign->ticket->requestor->firstname . ' ' .
                                            $reassign->ticket->requestor->lastname }}
                                        </span>
                                        <small class="n-mt-1"><strong>From: </strong>{{
                                            Str::limit($reassign->ticket->district->district_name, 30)
                                            }}</small>
                                    </span>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="d-flex flex-column ms-1">
                                        <strong><i class="fi fi-ss-list-dropdown"></i> Nature</strong>
                                        <span class="n-mt-1">
                                            {{ $reassign->ticket->ticketNature->ticket_nature_name }}
                                        </span>
                                    </small>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="d-flex flex-column ms-1">
                                        <strong><i class="fi fi-ss-calendar-day"></i> Requested</strong>
                                        <span class="n-mt-1">
                                            {{ $reassign->ticket->created_at->format('F j, Y g:i a') }}
                                        </span>
                                    </small>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="d-flex flex-column ms-1">
                                        <strong><i class="fi fi-ss-phone-rotary"></i> Contact No.</strong>
                                        <span class="n-mt-1">
                                            {{ $reassign->ticket->requestor->contact_number }}
                                        </span>
                                    </small>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="d-flex flex-column ms-1">
                                        <strong><i class="fi fi-ss-envelope"></i> E-Mail</strong>
                                        <span class="n-mt-1">
                                            {{ $reassign->ticket->requestor->email }}
                                        </span>
                                    </small>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <div class="d-flex flex-column ms-1">
                                        <h6>
                                            <span class="fw-bold">Ticket Status:</span> {{
                                            $reassign->ticket->status->status_name }}
                                        </h6>
                                        <hr>
                                        <h6 class="fw-bold"><i
                                                class="fi fi-ss-code-pull-request"></i>&nbsp;Reassign&nbsp;Request</h6>
                                        <span class="mt-1">
                                            Technician <strong>{{ $reassign->fromTechnician->lastname }}</strong>
                                            requested to reassign this ticket to you.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer col-12 d-flex justify-content-end">
                            <a href="{{ route('shared.show-ticket', ['id' => $reassign->ticket_id, 'route' => Route::currentRouteName()]) }}"
                                class="btn btn-sm btn-primary me-2 fw-semibold">View Details</a>
                            <button class="btn btn-sm btn-success fw-semibold" data-bs-toggle="modal"
                                data-bs-target="#acceptOrRejectRequest" data-reassign="{{ $reassign->id }}">Accept
                                Reassign</button>
                        </div>
                    </div>
                </div>
                @empty
                <h5 class="text-center fw-bold text-white">--No reassign requests--</h5>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div class="p-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <div class="row mt-2">
                    <div class="col-sm-12 col-md-6 col-xl-3 mb-3">
                        <small class="fw-semibold">Search requestor</small>
                        <form action="{{ route('shared.my-tickets') }}" method="GET" class="d-flex">
                            @foreach (request()->except('searchRequestor') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="text" class="form-control border-2 border-success"
                                placeholder="Search Requestor" name="searchRequestor" autocomplete="off"
                                value="{{ request('searchRequestor') }}">
                            <button type="submit" class="btn btn-success ms-1"><i
                                    class="fi fi-ss-member-search"></i></button>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-3 mb-3">
                        <small class="fw-semibold">Filter by status</small>
                        <x-dropdown title="{{ request('status_name') ? request('status_name') : 'All' }}"
                            route="{{ route('shared.my-tickets') }}">
                            @foreach ($statuses as $status)
                            <a class="dropdown-item text-truncate"
                                href="{{ route('shared.my-tickets', array_merge(request()->query(), ['status_name' => $status->status_name])) }}">
                                {{ $status->status_name }}
                            </a>
                            @endforeach
                        </x-dropdown>
                    </div>
                    <div class="col-sm-12 col-md-6 col-xl-3 mb-3">
                        <small class="fw-semibold">Filter by ticket nature</small>
                        <x-dropdown title="{{ request('ticket_nature_name') ? request('ticket_nature_name') : 'All' }}"
                            route="{{ route('shared.my-tickets') }}">
                            @foreach ($ticketNatures as $ticket_nature)
                            <a class="dropdown-item text-truncate"
                                href="{{ route('shared.my-tickets', array_merge(request()->query(), ['ticket_nature_name' => $ticket_nature->ticket_nature_name])) }}">
                                {{ $ticket_nature->ticket_nature_name }}
                            </a>
                            @endforeach
                        </x-dropdown>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 row">
                <div class="col-12 col-lg-8 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><small class="fw-semibold">ID</small></th>
                                <th><small class="fw-semibold">REQUESTOR</small></th>
                                <th><small class="fw-semibold">TICKET&nbsp;NATURE</small></th>
                                <th><small class="fw-semibold">REQUESTED</small></th>
                                <th><small class="fw-semibold">ASSIGNED</small></th>
                                <th><small class="fw-semibold">STATUS</small></th>
                                <th class="text-center"><small><i class="fi fi-ss-settings-sliders"></i></small></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                            @php
                            $pendingReassign = $ticket->ticket->mostRecentPendingReassignRequest();
                            @endphp
                            <tr>
                                <td>
                                    #{{ $ticket->ticket->id }}
                                </td>
                                <td class="d-flex flex-column" style="white-space: nowrap;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;">
                                    <small class="fw-semibold">{{ $ticket->ticket->requestor->firstname . ' ' .
                                        $ticket->ticket->requestor->lastname }}</small>
                                    @if($ticket->if_priority)
                                    <small class="text-danger fw-bold mt-1">
                                        PRIORITY
                                    </small>
                                    @endif
                                    @if($pendingReassign)
                                    <small class="text-indi fw-bold mt-1">
                                        REASSIGNING
                                    </small>
                                    @endif
                                </td>
                                <td>
                                    <small class="fw-semibold">
                                        {{ $ticket->ticket->ticketNature->ticket_nature_name }}
                                    </small>
                                </td>
                                <td>
                                    <small class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($ticket->ticket->created_at)->format('F j, Y g:i a') }}
                                    </small>
                                </td>
                                <td>
                                    <small class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($ticket->date_assigned)->format('F j, Y g:i a') }}
                                    </small>
                                </td>
                                <td>
                                    @php
                                    $color = match($ticket->ticket->status->status_name) {
                                    'Assigned' => 'warning',
                                    'In Progress' => 'primary',
                                    'Repaired' => 'info',
                                    'To CITC' => 'primary',
                                    'For Waste' => 'danger',
                                    'For Release' => 'success'
                                    };
                                    @endphp
                                    <x-user-role :color="$color">
                                        <small>
                                            @if($ticket->ticket->status_id === 2)
                                            Unopened
                                            @else
                                            {{ $ticket->ticket->status->status_name }}
                                            @endif

                                        </small>
                                    </x-user-role>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <a class="btn" href="#" role="button" id="dropdownMenuLink"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fi fi-ss-menu-dots fs-5"></i>
                                        </a>

                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @if($ticket->ticket->status_id == 2)
                                            <li>
                                                <button class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#openTicket"
                                                    data-ticketID="{{ $ticket->ticket_id }}"
                                                    data-ticketAssignID="{{ $ticket->id }}"
                                                    data-requestor="{{ $ticket->ticket->requestor->firstname . ' ' . $ticket->ticket->requestor->lastname }}"
                                                    data-nature="{{ $ticket->ticket->ticketNature->ticket_nature_name }}"
                                                    data-device="{{ $ticket->ticket->device->device_name }}"
                                                    data-district="{{ $ticket->ticket->district->district_name }}"
                                                    data-requested="{{ $ticket->ticket->created_at->format('F j, Y g:i a') }}"
                                                    data-assigned="{{ \Carbon\Carbon::parse($ticket->date_assigned)->format('F j, Y g:i a') }}">
                                                    Open Ticket
                                                </button>
                                            </li>
                                            @else
                                            <li>
                                                <a href="{{ route('shared.show-ticket' , ['id' => $ticket->ticket_id, 'route' => Route::currentRouteName()]) }}"
                                                    class="dropdown-item">
                                                    View Ticket
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                @if ($pendingReassign)
                                                <!-- Display dropdown for pending reassign request -->
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#pendingReassignRequest"
                                                    data-reassignId="{{ $pendingReassign->id }}" data-technician="{{ $pendingReassign->toTechnician->firstname
                                                    . " " . $pendingReassign->toTechnician->lastname }}"
                                                    data-id="{{ $ticket->ticket->id }}"
                                                    data-requestor="{{ $ticket->ticket->requestor->firstname . " " . $ticket->ticket->requestor->lastname }}"
                                                    data-ticketNature="{{ $ticket->ticket->ticketNature->ticket_nature_name }}"
                                                    data-date="{{ $pendingReassign->created_at }}">
                                                    View Pending Request
                                                </a>
                                                @else
                                                <!-- Display dropdown for making a new reassign request -->
                                                <a class="dropdown-item" data-bs-toggle="modal"
                                                    data-bs-target="#reassignTicket" data-id="{{ $ticket->ticket->id }}"
                                                    data-requestor="{{ $ticket->ticket->requestor->firstname . " " . $ticket->ticket->requestor->lastname }}"
                                                    data-ticketNature="{{ $ticket->ticket->ticketNature->ticket_nature_name }}">
                                                    Reassign Ticket
                                                </a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-center text-gray fw-semibold">
                                        --- NO TICKET RECORDS ---
                                    </h5>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-2">
                        {{ $tickets->links() }}
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card p-4" style="height: 350px">
                        <h6 class="fw-bold mb-0 mt-2 text-center">PENDING TICKETS</h6>
                        <div class="card-body">
                            <canvas id="pendingTicketsPieChart" height="auto"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.shared.modals.open')
@include('pages.shared.modals.reassign-ticket')
@include('pages.shared.modals.pending-reassign-request')
@include('pages.shared.modals.reassign-accept')
@vite(['public/js/technician-charts.js/pending-tickets-piechart.js'])
<script>
    document.querySelector(".sliding-panel-toggle").addEventListener("click", () => {
            document.querySelector(".tickets-wrapper").classList.toggle("sliding-panel-open");
        });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Open ticket
        const openTicketModal = document.getElementById('openTicket');

        openTicketModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const ticketID = button.getAttribute('data-ticketID');
            const ticketAssignID = button.getAttribute('data-ticketAssignID');
            const requestor = button.getAttribute('data-requestor');
            const ticketNature = button.getAttribute('data-nature');
            const device = button.getAttribute('data-device');
            const district = button.getAttribute('data-district');
            const requested = button.getAttribute('data-requested');
            const assigned = button.getAttribute('data-assigned');

            const ticketAssignID_input = document.getElementById('openTicketAssignID');
            const ticketID_input = document.getElementById('ticketID')
            const ticketID_span = document.getElementById('openTicketID');
            const requestor_span = document.getElementById('openRequestor');
            const ticketNature_span = document.getElementById('openTicketNature');
            const device_span = document.getElementById('openDevice');
            const district_span = document.getElementById('openDistrict');
            const requested_span = document.getElementById('openRequested');
            const assigned_span = document.getElementById('openAssigned');

            ticketAssignID_input.value = ticketAssignID;
            ticketID_input.value = ticketID;
            ticketID_span.textContent = ticketID;
            requestor_span.textContent = requestor;
            ticketNature_span.textContent = ticketNature;
            device_span.textContent = device;
            district_span.textContent = district;
            requested_span.textContent = requested;
            assigned_span.textContent = assigned;
        });

        const reassignModal = document.getElementById('reassignTicket');
        
        reassignModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const ticket_id = button.getAttribute('data-id');
            const requestor = button.getAttribute('data-requestor');
            const ticketNature = button.getAttribute('data-ticketNature');
            
            const reassignTicketId = document.getElementById('reassignTicketId');
            const displayTicketId = document.getElementById('displayTicketId');
            const displayRequestor = document.getElementById('displayRequestor');
            const displayTicketNature = document.getElementById('displayTicketNature');
            
            reassignTicketId.value = ticket_id;
            displayTicketId.textContent = ticket_id;
            displayRequestor.textContent = requestor;
            displayTicketNature.textContent = ticketNature;
        });

        const pendingReassignRequestModal = document.getElementById('pendingReassignRequest');

        pendingReassignRequestModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const reassign_ticket_id = button.getAttribute('data-reassignId');
            const to_technician = button.getAttribute('data-technician');
            const ticket_id = button.getAttribute('data-id');
            const requestor = button.getAttribute('data-requestor');
            const ticketNature = button.getAttribute('data-ticketNature');
            const dateRequested = button.getAttribute('data-date');
            
            const viewReassignTicketId = document.getElementById('viewReassignTicketId');
            const viewToTechnician = document.getElementById('displayToTechnician');
            const displayTicketId = document.getElementById('displayReassignTicketId');
            const displayRequestor = document.getElementById('displayReassignRequestor');
            const displayTicketNature = document.getElementById('displayReassignTicketNature');
            const displayDateRequested = document.getElementById('displayReassignDateRequested');

            viewReassignTicketId.value = reassign_ticket_id;
            viewToTechnician.textContent = to_technician;
            displayTicketId.textContent = ticket_id;
            displayRequestor.textContent = requestor;
            displayTicketNature.textContent = ticketNature;
            displayDateRequested.textContent = dateRequested;

        });

        const acceptOrRejectRequestModal = document.getElementById('acceptOrRejectRequest');

        acceptOrRejectRequestModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const reassign_ticket_id = button.getAttribute('data-reassign');

            const acceptReassignRequestIdInput = document.getElementById('acceptReassignRequestId');

            acceptReassignRequestIdInput.value = reassign_ticket_id;

        }); 
    });
</script>
@endsection