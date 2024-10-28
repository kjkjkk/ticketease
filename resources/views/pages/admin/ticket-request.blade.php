@extends('layouts.master')
@section('title', 'TicketEase | Ticket Request')
@section('nav-title', 'Ticket Requests')
@section('content')
<style>
    @media (max-width: 390px) {
        .lists {
            flex-direction: column;
        }
    }
</style>
<div class="p-4">
    <div class="row">
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="danger" status="1" role="Admin">
                <i class="fi fi-ss-time-add"></i>
            </x-overview-card>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="warning" status="2" role="Admin">
                <i class="fi fi-ss-curve-arrow"></i>
            </x-overview-card>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="primary" status="3" role="Admin">
                <i class="fi fi-ss-file-chart-line"></i>
            </x-overview-card>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="success" status="4" role="Admin">
                <i class="fi fi-ss-handshake"></i>
            </x-overview-card>
        </div>
    </div>
    <div class="col-12 mx-auto">
        <div class="card shadow-sm">
            <div class="card-header bg-white p-0">
                <ul class="lists d-flex my-3 gap-3">
                    <li class="requestor-nav-link active" id="requestLi" onclick="toggleContainers('requests')">Ticket
                        Requests
                    </li>
                    <li class="requestor-nav-link" id="queueLi" onclick="toggleContainers('queue')">Ticket Queue</li>

                </ul>
            </div>
            <div class="card-body py-3 px-4" style="max-height: 600px; overflow-y: auto;">
                <div id="ticket-requests" class="d-block">
                    <div class="container-fluid table-responsive" style="min-height: 50vh;">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-xl-3 mb-3">
                                <small class="fw-semibold">Search requestor</small>
                                <form action="{{ route('admin.ticket-request') }}" method="GET" class="d-flex">
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

                            <div class="col-sm-12 col-md-4 col-xl-3 mb-3">
                                <small class="fw-semibold">Filter by status</small>
                                <x-dropdown title="{{ request('status_name') ? request('status_name') : 'All' }}"
                                    route="{{ route('admin.ticket-request') }}">
                                    @foreach ($statuses as $status)
                                    <a class="dropdown-item text-truncate"
                                        href="{{ route('admin.ticket-request', array_merge(request()->query(), ['status_name' => $status->status_name])) }}">
                                        {{ $status->status_name }}
                                    </a>
                                    @endforeach
                                </x-dropdown>
                            </div>

                            <div class="col-sm-12 col-md-4 col-xl-3 mb-3">
                                <small class="fw-semibold">Filter by ticket nature</small>
                                <x-dropdown
                                    title="{{ request('ticket_nature_name') ? request('ticket_nature_name') : 'All' }}"
                                    route="{{ route('admin.ticket-request') }}">
                                    @foreach ($ticketNatures as $ticket_nature)
                                    <a class="dropdown-item text-truncate"
                                        href="{{ route('admin.ticket-request', array_merge(request()->query(), ['ticket_nature_name' => $ticket_nature->ticket_nature_name])) }}">
                                        {{ $ticket_nature->ticket_nature_name }}
                                    </a>
                                    @endforeach
                                </x-dropdown>
                            </div>
                        </div>
                        <table class="table table-bordered user-table" id="requestTable">
                            <thead class="table-logo-dark">
                                <tr>
                                    @foreach (['#', 'Requestor', 'Ticket Nature', 'Date Requested', 'District',
                                    'Technician',
                                    'Status'] as $header)
                                    <th>{{ $header }}</th>
                                    @endforeach
                                    <th class="text-center"><i class="fi fi-ss-settings-sliders"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ticketPending as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td>
                                    <td>{{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname}} </td>
                                    <td>{{ $ticket->ticketNature->ticket_nature_name }}</td>
                                    <td>
                                        <small><span class="fw-semibold" class="fw-semibold">Requested:</span> {{
                                            $ticket->created_at->format('F j, Y g:i a')
                                            }}</small>
                                        <br>
                                        <small><span class="fw-semibold" class="fw-semibold">Assigned:</span> {{
                                            $ticket->ticketAssign->created_at->format('F
                                            j, Y g:i a') }}</small>
                                    </td>
                                    <td>{{ $ticket->district->district_name }}</td>
                                    <td>{{ $ticket->ticketAssign->technician->firstname . ' ' .
                                        $ticket->ticketAssign->technician->lastname }}</td>
                                    <td>
                                        @php
                                        $color = match($ticket->status->status_name) {
                                        'Unassigned' => 'danger',
                                        'Assigned' => 'warning',
                                        'In Progress' => 'primary',
                                        'Repaired' => 'info',
                                        'For Release' => 'success',
                                        };
                                        @endphp
                                        <x-user-role :color="$color">
                                            {{ $ticket->status->status_name }}
                                        </x-user-role>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn" href="#" role="button" id="dropdownMenuLink"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fi fi-ss-menu-dots fs-5"></i>
                                            </a>

                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <li>
                                                    <a href="{{ route('shared.show-ticket', ['id' => $ticket->id, 'route' => Route::currentRouteName()]) }}"
                                                        class="dropdown-item">View</a>
                                                </li>
                                                @if($ticket->status_id != 2)
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#generateServiceReport"
                                                        class="dropdown-item"
                                                        data-ticket-id="{{ $ticket->id }}">Generate Service Report</a>
                                                </li>
                                                <li>
                                                    <a data-bs-toggle="modal" data-bs-target="#downloadServiceReport"
                                                        class="dropdown-item"
                                                        data-ticket-id="{{ $ticket->id }}">Download Service Report</a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center fw-semibold py-3">
                                        --- No pending ticket requests ---
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="p-1">
                            {{ $ticketPending->links() }}
                        </div>
                    </div>
                </div>
                <div id="ticket-queue" class="d-none">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
                        @forelse ($ticketQueue as $index => $ticket)
                        <div class="col">
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-white d-flex align-items-center">
                                    <div class="circle-sm bg-light-subtle">
                                        <i class="fi fi-ss-ticket mt-1"></i>
                                    </div>
                                    <small class="fw-semibold ms-2">Ticket No.</small>
                                    <h6 class="font-weight-bold ms-2 mt-2">#{{ $ticket->id }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 d-flex mb-3">
                                            <x-user-box size="md">{{ substr($ticket->requestor->firstname, 0, 1) }}
                                            </x-user-box>
                                            <span class="d-flex flex-column ms-1">
                                                <span class="fw-semibold">
                                                    {{ $ticket->requestor->firstname . ' ' .
                                                    $ticket->requestor->lastname }}
                                                </span>
                                                <small class="n-mt-1"><strong>From: </strong>{{
                                                    Str::limit($ticket->district->district_name, 30)
                                                    }}</small>
                                            </span>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="d-flex flex-column ms-1">
                                                <strong><i class="fi fi-ss-list-dropdown"></i> Nature</strong>
                                                <span class="n-mt-1">
                                                    {{ $ticket->ticketNature->ticket_nature_name }}
                                                </span>
                                            </small>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="d-flex flex-column ms-1">
                                                <strong><i class="fi fi-ss-calendar-day"></i> Requested</strong>
                                                <span class="n-mt-1">
                                                    {{ $ticket->created_at->format('F j, Y g:i a') }}
                                                </span>
                                            </small>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="d-flex flex-column ms-1">
                                                <strong><i class="fi fi-ss-phone-rotary"></i> Contact No.</strong>
                                                <span class="n-mt-1">
                                                    {{ $ticket->requestor->contact_number }}
                                                </span>
                                            </small>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="d-flex flex-column ms-1">
                                                <strong><i class="fi fi-ss-envelope"></i> E-Mail</strong>
                                                <span class="n-mt-1">
                                                    {{ $ticket->requestor->email }}
                                                </span>
                                            </small>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('shared.show-ticket', ['id' => $ticket->id, 'route' => Route::currentRouteName()]) }}"
                                                class="text-primary"><small>View details</small></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end gap-2">
                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#invalidTicket" data-id="{{ $ticket->id }}"
                                        data-name="{{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }}"
                                        data-nature="{{ $ticket->ticketNature->ticket_nature_name }}"
                                        data-device="{{ $ticket->device->device_name }}"
                                        data-created="{{ $ticket->created_at->format('F j, Y g:i a') }}"
                                        data-district="{{ $ticket->district->district_name }}">
                                        Invalid
                                    </button>
                                    @if ($index == 0)
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#assignTicket" data-id="{{ $ticket->id }}"
                                        data-name="{{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }}"
                                        data-nature="{{ $ticket->ticketNature->ticket_nature_name }}"
                                        data-device="{{ $ticket->device->device_name }}"
                                        data-created="{{ $ticket->created_at->format('F j, Y g:i a') }}"
                                        data-district="{{ $ticket->district->district_name }}">
                                        Assign
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <h6 class="text-start text-gray fw-semibold">
                            NO TICKET QUEUE
                        </h6>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('pages.admin.modals.ticket.assign')
@include('pages.admin.modals.ticket.invalid')
@include('pages.admin.report.modals.download-service-report')
@include('pages.admin.report.modals.generate-service-report')
<script>
    function toggleContainers(container) {
        const queueLi = document.getElementById('queueLi');
        const requestLi = document.getElementById('requestLi');
        const queueContainer = document.getElementById('ticket-queue');
        const requestsContainer = document.getElementById('ticket-requests');
        
        if (container === 'queue') {
            // Toggle the container visibility
            queueContainer.classList.remove('d-none');
            queueContainer.classList.add('d-block');
            requestsContainer.classList.remove('d-block');
            requestsContainer.classList.add('d-none');
            // Toggle the list active class
            queueLi.classList.add('active');
            requestLi.classList.remove('active');
        } else if (container === 'requests') {
            // Toggle the container visibility
            requestsContainer.classList.remove('d-none');
            requestsContainer.classList.add('d-block');
            queueContainer.classList.remove('d-block');
            queueContainer.classList.add('d-none');
            // Toggle the list active class
            requestLi.classList.add('active');
            queueLi.classList.remove('active');
        }
    }
    
    document.addEventListener('DOMContentLoaded', () => {
        const assignTicketModal = document.getElementById('assignTicket');
        assignTicketModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-id');
            const requestorName = button.getAttribute('data-name')
            const ticketNature = button.getAttribute('data-nature');
            const device = button.getAttribute('data-device');
            const dateRequested = button.getAttribute('data-created');
            const requestorDistrict = button.getAttribute('data-district');
            
            const inputTicketId = document.getElementById('assignTicketId');
            const spanRequestorName = document.getElementById('assignRequestorName');
            const spanDateRequested = document.getElementById('assignDateRequested');
            const spanTicketNature = document.getElementById('assignTicketNature');
            const spanTicketDevice = document.getElementById('assignTicketDevice');
            const spanRequestorDistrict = document.getElementById('assignRequestorDistrict');
            
            inputTicketId.value = ticketId;
            spanRequestorName.textContent = requestorName;
            spanDateRequested.textContent = dateRequested;
            spanTicketNature.textContent = ticketNature;
            spanTicketDevice.textContent = device;
            spanRequestorDistrict.textContent = requestorDistrict;
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const assignTicketModal = document.getElementById('invalidTicket');
        assignTicketModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-id');
            const requestorName = button.getAttribute('data-name')
            const ticketNature = button.getAttribute('data-nature');
            const device = button.getAttribute('data-device');
            const dateRequested = button.getAttribute('data-created');
            const requestorDistrict = button.getAttribute('data-district');
            
            const inputTicketId = document.getElementById('invalidTicketId');
            const spanRequestorName = document.getElementById('invalidRequestorName');
            const spanDateRequested = document.getElementById('invalidDateRequested');
            const spanTicketNature = document.getElementById('invalidTicketNature');
            const spanTicketDevice = document.getElementById('invalidTicketDevice');
            const spanRequestorDistrict = document.getElementById('invalidRequestorDistrict');
            
            inputTicketId.value = ticketId;
            spanRequestorName.textContent = requestorName;
            spanDateRequested.textContent = dateRequested;
            spanTicketNature.textContent = ticketNature;
            spanTicketDevice.textContent = device;
            spanRequestorDistrict.textContent = requestorDistrict;
        });        
    });

    document.addEventListener('DOMContentLoaded', () => {
        const generateServiceReportModal = document.getElementById('generateServiceReport');
        generateServiceReportModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-ticket-id');
            
            const inputTicketId = document.getElementById('generateServiceReportTicketID')

            inputTicketId.value = ticketId;
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const generateServiceReportModal = document.getElementById('downloadServiceReport');
        generateServiceReportModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-ticket-id');
            
            const inputTicketId = document.getElementById('downloadServiceReportTicketID')

            inputTicketId.value = ticketId;
        });
    });
</script>
@endsection