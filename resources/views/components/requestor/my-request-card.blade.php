<div class="col-12 col-lg-6">
    <div class="card my-request-card">
        <div class="p-3">
            <div class="d-flex align-items-center">
                <div class="ticket-gif">
                    <img src="{{ asset('img/ticket.gif') }}" class="img-fluid rounded-circle" alt="Employee Image">
                </div>
                <h5 class="mb-0 ms-2 fw-semibold text-logo-dark">Hardware Repair</h5>
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
                <span class="text-{{ $color }} fw-bold ms-2 text-uppercase border-bottom">{{
                    $ticket->status->status_name
                    }}</span>
                <div class="ms-auto">
                    <a href="{{ route('requestor.view-ticket', [$ticket->id]) }}">
                        <small class="fw-semibold text-primary border-bottom border-2">View more details</small>
                    </a>
                </div>
            </div>
            <hr>
            <div class="row">
                <span class="fw-semibold text-muted my-2">Ticket Info.</span>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-ticket"></i>
                            Ticket ID</strong>
                        <span class="n-mt-1">
                            {{ $ticket->id }}
                        </span>
                    </small>
                </div>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-paper-plane"></i>
                            Date Submitted</strong>
                        <span class="n-mt-1">
                            {{ \Carbon\Carbon::parse($ticket->date_submitted)->format('F j, Y g:i a') }}
                        </span>
                    </small>
                </div>
                <span class="fw-semibold text-muted my-2">Device Info.</span>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-devices"></i>
                            Device</strong>
                        <span class="n-mt-1">
                            {{ $ticket->device->device_name }}
                        </span>
                    </small>
                </div>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-brand"></i>
                            Brand</strong>
                        <span class="n-mt-1">
                            {{ $ticket->brand }}
                        </span>
                    </small>
                </div>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-model-cube-space"></i>
                            Model</strong>
                        <span class="n-mt-1">
                            {{ $ticket->model }}
                        </span>
                    </small>
                </div>
                @if($ticket->ticketAssign)
                <span class="fw-semibold text-muted my-2">Technician Info.</span>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-user-gear"></i>
                            Technician</strong>
                        <span class="n-mt-1">
                            {{ $ticket->ticketAssign->technician->firstname . ' ' .
                            $ticket->ticketAssign->technician->lastname }}
                        </span>
                    </small>
                </div>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-envelope"></i>
                            Email</strong>
                        <span class="n-mt-1">
                            {{ $ticket->ticketAssign->technician->email }}
                        </span>
                    </small>
                </div>
                <div class="col-4 mb-2">
                    <small class="d-flex flex-column ms-1">
                        <strong class="border-bottom border-2 mb-2 text-muted"><i class="fi fi-ss-phone-rotary"></i>
                            Phone No.</strong>
                        <span class="n-mt-1">
                            {{ $ticket->ticketAssign->technician->contact_number }}
                        </span>
                    </small>
                </div>
                @else
                <span class="fw-semibold text-danger mb-2 mt-2">Not Assigned</span>
                @endif
            </div>
        </div>
    </div>
</div>