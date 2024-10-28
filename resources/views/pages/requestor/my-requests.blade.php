@extends('layouts.master')
@section('title', 'TicketEase | My Requests')
@section('content')
<div class="p-5">
    <div class=" bg-secondary-subtle p-3 rounded">
        <div class="col-12 col-md-8 col-lg-5 col-xl-4">
            <div class="card p-3">
                <span class="fw-semibold">
                    <i class="fi fi-ss-calendar me-1"></i>Filter by date submitted
                </span>
                <hr style="margin-top: -2px;">
                <form action="{{ route('requestor.my-requests') }}">
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" style="min-width: 70px;">FROM:</span>
                        <input type="date" name="fromDate" class="form-control" value="{{ request('fromDate') }}"
                            required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text fw-bold" style="min-width: 70px;">TO:</span>
                        <input type="date" name="toDate" class="form-control" value="{{ request('toDate') }}" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('requestor.my-requests') }}" class="btn btn-warning fw-semibold">
                            <i class="fi fi-ss-clear-alt me-1"></i>Clear Filter
                        </a>
                        <button type=" submit" class="btn btn-logo">
                            <i class="fi fi-ss-search mt-2 me-1"></i> Filter Tickets
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            @forelse ($tickets as $ticket)
            <x-requestor.my-request-card :ticket="$ticket"></x-requestor.my-request-card>
            @empty
            <h1 class="text-center fw-semibold">No ticket requests</h1>
            @endforelse
        </div>
        {{ $tickets->links() }}
    </div>
</div>

@endsection