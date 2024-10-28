@extends('layouts.master')
@section('title', 'TicketEase | Reports')
@section('nav-title', 'Reports')
@section('content')
<div class="p-4">
    <div class="col-12 card shadow-sm">
        <div class="card-header bg-white pt-3 d-flex">
            <i class="fi fi-ss-table-tree me-2"></i>
            <h6 class="fw-bold">Customize Report</h6>
        </div>
        <div class="card-body p-3 bg-secondary-subtle">
            <form action="{{ route('admin.export') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-6 col-xl-4 mb-2">
                        <!-- Select Columns -->
                        <div class="card">
                            <div class="card-header bg-light">
                                <span class="fw-semibold mb-2">
                                    <i class="fi fi-ss-choose me-1"></i>Select columns
                                </span>
                            </div>
                            <div class="card-body p-2">
                                <div class="border border-2 px-2 py-1">
                                    @foreach ($columns as $col)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="columns[]"
                                            value="{{ $col['db_column'] }}" id="column-{{ $col['column'] }}" checked>
                                        <label class="form-check-label" for="column-{{ $col['column'] }}">
                                            {{ strtoupper($col['column']) }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6 col-xl-4 mb-3">
                        <!-- Filters Section -->
                        <div class="accordion accordion-flush" id="filterAccordion">
                            <!-- Ticket Nature Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTicketNature">
                                    <button class="accordion-button collapsed fw-bold border border-2" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTicketNature"
                                        aria-expanded="false" aria-controls="collapseTicketNature">
                                        <i class="fi fi-ss-filter me-1"></i>Filter by Ticket Nature
                                    </button>
                                </h2>
                                <div id="collapseTicketNature" class="accordion-collapse collapse"
                                    aria-labelledby="headingTicketNature" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body" style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($ticketNatures as $ticketNature)
                                        <div class="border border-2 px-2 py-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="ticket_nature[]"
                                                    value="{{ $ticketNature->id }}" id="nature-{{ $ticketNature->id }}"
                                                    checked>
                                                <label class="form-check-label" for="nature-{{ $ticketNature->id }}">
                                                    {{ $ticketNature->ticket_nature_name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- District Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingDistricts">
                                    <button class="accordion-button collapsed fw-bold border border-2" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseDistricts"
                                        aria-expanded="false" aria-controls="collapseDistricts">
                                        <i class="fi fi-ss-filter me-1"></i>Filter by Districts
                                    </button>
                                </h2>
                                <div id="collapseDistricts" class="accordion-collapse collapse"
                                    aria-labelledby="headingDistricts" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body" style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($districts as $district)
                                        <div class="border border-2 px-2 py-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="district[]"
                                                    value="{{ $district->id }}" id="district-{{ $district->id }}"
                                                    checked>
                                                <label class="form-check-label" for="district-{{ $district->id }}">
                                                    {{ $district->district_name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Statuses Filter -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingStatuses">
                                    <button class="accordion-button collapsed fw-bold border border-2" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseStatuses"
                                        aria-expanded="false" aria-controls="collapseStatuses">
                                        <i class="fi fi-ss-filter me-1"></i>Filter by Status
                                    </button>
                                </h2>
                                <div id="collapseStatuses" class="accordion-collapse collapse"
                                    aria-labelledby="headingStatuses" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body" style="max-height: 300px; overflow-y: auto;">
                                        @foreach ($statuses as $status)
                                        <div class="border border-2 px-2 py-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="status[]"
                                                    value="{{ $status->id }}" id="status-{{ $status->id }}" checked>
                                                <label class="form-check-label" for="status-{{ $status->id }}">
                                                    {{ $status->status_name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <!-- Date Range Filter -->
                        <div class="card p-3">
                            <span class="fw-semibold">
                                <i class="fi fi-ss-calendar me-1"></i>Date Range
                            </span>
                            <hr style="margin-top: -2px;">
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold" style="min-width: 70px;">FROM:</span>
                                <input type="date" name="date_from" class="form-control" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text fw-bold" style="min-width: 70px;">TO:</span>
                                <input type="date" name="date_to" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="sheetPassword" class="fw-semibold">
                                    <i class="fi fi-ss-compliance-document me-1"></i>Set password for protection
                                </label>
                                <div class="input-group">
                                    <input type="password" id="sheetPassword" name="sheetPassword" class="form-control"
                                        placeholder="Enter password">
                                    <button class="btn btn-dark" type="button" id="togglePassword">
                                        <i class="fi fi-ss-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-logo">
                                <i class="fi fi-ss-newspaper me-2"></i>Generate report .xlsx
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('sheetPassword');
        const passwordType = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', passwordType);
        
        // Optionally change the icon
        this.querySelector('i').classList.toggle('fi-ss-eye');
        this.querySelector('i').classList.toggle('fi-ss-eye-crossed');
    });
</script>
@endsection