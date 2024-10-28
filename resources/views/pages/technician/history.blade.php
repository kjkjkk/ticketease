@extends('layouts.master')
@section('title', 'TicketEase | History')
@section('nav-title', 'Historys')
@section('content')
<div class="p-4">
    <div class="container-fluid p-0">
        <div class="bg-white rounded shadow-sm">
            <div class="row p-3 d-flex align-items-center rounded">
                <div class="col-sm-12 col-md-6 col-xl-3 mb-3">
                    <small class="fw-semibold">Search by Ticket ID</small>
                    <form action="{{ route('technician.history') }}" method="GET" class="d-flex">
                        <input type="number" class="form-control border-2 border-success" placeholder="Enter ticket ID"
                            name="searchID" autocomplete="off" value="{{ request('searchID') }}">
                        <button type="submit" class="btn btn-success ms-1"><i
                                class="fi fi-ss-member-search"></i></button>
                    </form>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3 mb-3">
                    <small class="fw-semibold">Search Requestor</small>
                    <form action="{{ route('technician.history') }}" method="GET" class="d-flex">
                        @foreach (request()->except('searchUser') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <input type="text" class="form-control border-2 border-success" placeholder="Enter name"
                            name="searchUser" autocomplete="off" value="{{ request('searchUser') }}">
                        <button type="submit" class="btn btn-success ms-1"><i
                                class="fi fi-ss-member-search"></i></button>
                    </form>
                </div>
                <div class="col-sm-12 col-md-4 col-xl-3 mb-3">
                    <small class="fw-semibold">Filter by ticket nature</small>
                    <x-dropdown title="{{ request('ticket_nature_name') ? request('ticket_nature_name') : 'All' }}"
                        route="{{ route('technician.history') }}">
                        @foreach ($ticketNatures as $ticket_nature)
                        <a class="dropdown-item text-truncate"
                            href="{{ route('technician.history', array_merge(request()->query(), ['ticket_nature_name' => $ticket_nature->ticket_nature_name])) }}">
                            {{ $ticket_nature->ticket_nature_name }}
                        </a>
                        @endforeach
                    </x-dropdown>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive mt-3 rounded bg-white border p-3">
        <table class="table table-bordered user-table">
            <thead class="table-logo-dark">
                <tr>
                    @foreach (['#', 'Requestor', 'Ticket Nature', 'District', 'Status'] as $header)
                    <th>{{ $header }}</th>
                    @endforeach
                    <th class="text-center"><i class="fi fi-ss-settings-sliders"></i></th>
                </tr>
            </thead>
            <tbody>
                @if($tickets->isEmpty())
                <tr>
                    <td colspan="7" class="text-center fw-semibold py-3">--- No tickets found ---</td>
                </tr>
                @else
                @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }}</td>
                    <td>{{ $ticket->ticketNature->ticket_nature_name }}</td>
                    <td>{{ $ticket->district->district_name }}</td>
                    <td>
                        @php
                        $color = match($ticket->status->status_name) {
                        'To CITC' => 'primary',
                        'For Waste' => 'warning',
                        'Invalid' => 'danger',
                        'Closed' => 'success'
                        };
                        @endphp
                        <x-user-role :color="$color">
                            {{ $ticket->status->status_name }}
                        </x-user-role>
                    </td>
                    <td>
                        <a href="{{ route('view-ticket', ['id' => $ticket->id, 'route' => Route::currentRouteName()]) }}"
                            class="btn btn-sm btn-success fw-semibold">View Details</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        <div class="p-1">
            {{ $tickets->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection