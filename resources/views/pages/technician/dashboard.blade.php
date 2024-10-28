@extends('layouts.master')
@section('title', 'TicketEase | Dashboard')
@section('nav-title', 'Dashboards')
@section('content')
@include('reminders.technician-welcome')
<div class="p-4">
    <div class="row">
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="warning" status="2" role="Technician">
                <i class="fi fi-ss-curve-arrow"></i>
            </x-overview-card>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="primary" status="3" role="Technician">
                <i class="fi fi-ss-file-chart-line"></i>
            </x-overview-card>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="success" status="4" role="Technician">
                <i class="fi fi-ss-handshake"></i>
            </x-overview-card>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="info" status="7" role="Technician">
                <i class="fi fi-ss-time-add"></i>
            </x-overview-card>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-7">
            <div class="card px-3 pt-2">
                <div class="form-group mb-2 col-12 col-md-8 col-lg-6">
                    <label for="ticketsMonthly" class="fw-semibold">Select Year:</label>
                    <select name="ticketsMonthly" id="ticketsMonthly" class="form-control">
                        @foreach ($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Canvas for Line Chart -->
                <div class="card">
                    <h6 class="fw-bold mb-0 mt-2 text-center">YOUR TOTAL MONTHLY TICKETS</h6>
                    <div class="card-body">
                        <canvas id="monthlyTickets" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        {{-- Pending tickets chart --}}
        <div class="col-12 col-md-6 col-xl-5">
            <div class="card px-3 pt-2">
                <div class="form-group mb-2 col-12">
                    <label for="ticketNatureMonth" class="fw-semibold">Filter by Month:</label>
                    <input type="month" id="ticketNatureMonth" name="ticketNatureMonth" class="form-control"
                        value="{{ $currentMonth }}">
                </div>
                <h6 class="fw-bold mb-0 mt-2 text-center">TICKETS BY NATURE</h6>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="ticketsByNature" height="200"></canvas>
                </div>
                <div class="text-center">
                    <h6 class="fw-bold">Total Tickets: <span id="totalTicketsCount">0</span></h6>
                </div>
            </div>
        </div>
        {{-- Pie chart for Pending Tickets --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card p-3">
                <h6 class="fw-bold mb-0 mt-2 text-center">PENDING TICKETS</h6>
                <div class="card-body">
                    <canvas id="pendingTicketsPieChart" height="260"></canvas>
                </div>
            </div>
        </div>
        {{-- Newly assigned Tickets --}}
        <div class="col-12 col-xl-8">
            <div class="card" style="max-height: 350px; overflow-y: auto;">
                <div class="card-header bg-light">
                    <h6 class="fw-bold mt-2">New tickets</h6>
                </div>
                <div class="card-body p-3">
                    @foreach ($tickets as $ticket)
                    <div class="dashboard-ticket-card w-100">
                        <div class="dashboard-ticket-info">
                            <x-user-box size="lg">{{ substr($ticket->requestor->firstname, 0, 1) }}</x-user-box>
                            <div class="dashboard-ticket-details ms-2">
                                <span class="dashboard-ticket-title">
                                    <a href="" class="me-1 text-logo-dark">#{{ $ticket->id }}</a>
                                    {{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }}
                                </span>
                                <small class="fw-semibold n-mt-1">
                                    <span class="text-primary">{{ $ticket->ticketNature->ticket_nature_name }}</span>
                                    <span class="text-dark">{{ substr($ticket->district->district_name, 0, 10) }}</span>
                                </small>
                                <span class="dashboard-ticket-description n-mt-1">{{ substr($ticket->details, 0, 20)
                                    }}</span>
                            </div>
                        </div>
                        <div class="dashboard-ticket-status mt-3 mx-auto mx-sm-0">
                            Assigned {{ $ticket->created_at->diffForHumans()}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@vite(['public/js/technician-charts.js/monthly-tickets-barchart.js',
'public/js/technician-charts.js/ticket-natures-month-tickets.js',
'public/js/technician-charts.js/pending-tickets-piechart.js'])
<script>
    function openModal() {
        document.getElementById('technicianReminder').style.display = 'block';
    }
    function closeModal() {
        document.getElementById('technicianReminder').style.display = 'none';
    }
    var modal = document.getElementById('technicianReminder');
    var closeButton = document.querySelector('.close-button');
    closeButton.onclick = function() {
        closeModal();
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            
        }
    }
</script>
@endsection