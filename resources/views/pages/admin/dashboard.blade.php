@extends('layouts.master')
@section('title', 'TicketEase | Dashboard')
@section('nav-title', 'Dashboard')
@section('content')
@include('reminders.admin-welcome')
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
            <x-overview-card color="success" status="6" role="Technician">
                <i class="fi fi-ss-handshake"></i>
            </x-overview-card>
        </div>
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <x-overview-card color="indi" status="4" role="Technician">
                <i class="fi fi-ss-time-add"></i>
            </x-overview-card>
        </div>
    </div>
    <div class="row">
        {{-- District tickets by month --}}
        <div class="col-12 col-xl-8">
            <div class="card" style="height: 450px;">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">District tickets</span>
                        <div class="dropdown dropstart">
                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fi fi-ss-filters"></i>
                            </button>
                            <ul class="dropdown-menu px-2 bg-secondary" style="min-width: 300px;">
                                <div class="input-group">
                                    <span class="input-group-text" id="filter-month"><i
                                            class="fi fi-ss-calendar-lines"></i></span>
                                    <input type="month" id="districtMonth" name="districtMonth" class="form-control"
                                        aria-describedby="filter-month" value="{{ $currentMonth }}">
                                </div>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-5 px-3">
                    <canvas id="districtChart" height="300"></canvas>
                </div>
            </div>
        </div>
        {{-- Unclosed tickets --}}
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card" style="height: 450px">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center">
                        <span class="fw-semibold">Unresolved tickets</span>

                    </div>
                </div>
                <div class="card-body">
                    <canvas id="pendingTicketsPieChart" height="auto"></canvas>
                </div>
            </div>
        </div>
        {{-- Ticket natures by month --}}
        <div class="col-12 col-md-6 col-xl-7">
            <div class="card" style="height: 450px;">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Ticket nature's tickets</span>
                        <div class="dropdown dropstart">
                            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fi fi-ss-filters"></i>
                            </button>
                            <ul class="dropdown-menu px-2 bg-secondary" style="min-width: 330px;">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="ticketNature-filter-month"><i
                                            class="fi fi-ss-calendar-lines"></i></span>
                                    <input type="month" id="ticketNatureMonth" class="form-control"
                                        value="{{ $currentMonth }}" aria-describedby="ticketNature-filter-month">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text" id="ticketNature-filter-technician"><i
                                            class="fi fi-ss-user-gear"></i></span>
                                    <select name="technician_id" id="technician_id" class="form-control"
                                        aria-describedby="ticketNature-filter-technician">
                                        <option value="">All</option>
                                        @foreach ($technicians as $technician)
                                        <option value="{{ $technician->id }}">{{ $technician->firstname . ' ' .
                                            $technician->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body pb-5 px-3">
                    <canvas id="ticketNatureChart" height="300"></canvas>
                </div>
            </div>
        </div>
        {{-- Users chart --}}
        <div class="col-12 col-md-10 col-lg-9 col-xl-5">
            <div class="card" style="height: 450px;">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center">
                        <span class="fw-semibold">Ticket trends</span>

                    </div>
                </div>
                <div class="card-body p-4">
                    <x-trend color="indi" label="Most popular day">
                        {{ $popularDay->day }}
                    </x-trend>
                    <x-trend color="primary" label="Most popular ticket">
                        {{ $popularTicketNature->ticket_nature_name }}
                    </x-trend>
                    <x-trend color="info" label="Most ticket volume">
                        {{ $popularDistrict->district_name }}
                    </x-trend>
                    <x-trend color="success" label="Most popular device">
                        {{ $popularDevice->device_name }}
                    </x-trend>
                    <hr>
                    <h6 class="fw-bold">
                        <i class="fi fi-ss-newspaper me-1"></i>Generate Monthly Reports
                    </h6>
                    <form action="{{ route('admin.monthly-report') }}" method="GET">
                        <div class="input-group">
                            <input type="month" id="selectedMonth" name="selectedMonth"
                                class="form-control border-secondary" required>
                            <input type="password" id="sheetPassword" name="sheetPassword" placeholder="Password"
                                class="form-control border-secondary" required>
                            <button class="btn btn-logo" type="submit">
                                <i class="fi fi-ss-down-to-line"></i>
                            </button>
                        </div>
                    </form>
                    <hr>
                    <a href="{{ route('admin.reports') }}" class="btn btn-logo fw-bold">
                        <i class="fi fi-ss-customize-edit me-1"></i>Customize report
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@vite(['public/js/admin-charts/pending-tickets-piechart.js', 'public/js/admin-charts/district-tickets-linechart.js',
'public/js/admin-charts/ticket-nature-tickets-barchart.js'])
<script>
    function openModal() {
        document.getElementById('reminder').style.display = 'block';
    }
    function closeModal() {
        document.getElementById('reminder').style.display = 'none';
    }
    var modal = document.getElementById('reminder');
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