<x-modal id="viewTicketDetails-{{ $ticket->id }}" title="Ticket Details" size="md">
    <div class="row">
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">REQUESTOR</h6>
            <span class="ms-auto">{{$ticket->requestor->firstname}} {{$ticket->requestor->lastname}}</span>
        </div>
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">TICKET ID</h6>
            <span class="ms-auto">{{$ticket->id}}</span>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">TICKET NATURE</h6>
            <span class="ms-auto">{{$ticket->ticketNature->ticket_nature_name}}</span>
        </div>
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">DISTRICT</h6>
            <span class="ms-auto">{{$ticket->district->district_name}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">DEPARTMENT</h6>
            <span class="ms-auto">{{$ticket->department}}</span>
        </div>
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">DEVICE</h6>
            <span class="ms-auto">{{$ticket->device->device_name}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">BRAND</h6>
            <span class="ms-auto">{{$ticket->brand}}</span>
        </div>
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">MODEL</h6>
            <span class="ms-auto">{{$ticket->model}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">PROPERTY NO.</h6>
            <span class="ms-auto">{{$ticket->property_no}}</span>
        </div>
        <div class="col d-flex align-items-center justify-space-between gap-3">
            <h6 class="fw-semibold mb-0 me-2">SERIAL NO.</h6>
            <span class="ms-auto">{{$ticket->serial_no}}</span>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <h6 class="fw-semibold mb-2 me-2">DETAILS</h6>
            <input type="textarea" class="form-control" value="{{$ticket->details}}" disabled>
        </div>
    </div>
    <hr>
    <div class="float-end">
        <x-cancel-button>Close</x-cancel-button>
    </div>
</x-modal>