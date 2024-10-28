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
                    <small class="d-flex flex-column ms-1">
                        <strong>Requestor name</strong>
                        <span class="n-mt-1">
                            {{ $ticket->requestor->firstname . ' ' . $ticket->requestor->lastname }}
                        </span>
                    </small>
                </div>
                <div class="col-6">
                    <small class="d-flex flex-column ms-1">
                        <strong><i class="fi fi-ss-phone-rotary"></i> Contact No.</strong>
                        <span class="n-mt-1">
                            {{ $ticket->requestor->contact_number }}
                        </span>
                    </small>
                </div>
                <div class="col-6">
                    <small class="d-flex flex-column ms-1">
                        <strong><i class="fi fi-ss-envelope"></i> E-Mail</strong>
                        <span class="n-mt-1">
                            {{ $ticket->requestor->email }}
                        </span>
                    </small>
                </div>
                <a href="" class="text-primary mt-2"><small>View details</small></a>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <button class="btn btn-outline-danger btn-sm">Invalid</button>
            @if ($index == 0)
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#assignTicket"
                data-id="{{ $ticket->id }}"
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