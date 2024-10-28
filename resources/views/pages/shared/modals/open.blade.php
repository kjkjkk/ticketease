<x-modal id="openTicket" title="Open Ticket" size="md">
    <form action="{{ route('shared.open-ticket') }}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
        <div class="row">
            <input type="hidden" name="route" value="{{ Route::currentRouteName() }}">
            <input type="hidden" name="ticketID" id="ticketID">
            <input type="hidden" name="ticketAssignID" id="openTicketAssignID">
            <div class="col-3 mb-2">
                <span class="fw-semibold">Ticket #: </span><span id="openTicketID"></span>
            </div>
            <div class="col-9 mb-2">
                <span class="fw-semibold">Requestor: </span><span id="openRequestor"></span>
            </div>
            <hr>
            <div class="col-12 mb-2">
                <span class="fw-semibold">Ticket Nature: </span><span id="openTicketNature"></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-semibold">Device: </span><span id="openDevice"></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-semibold">Requested: </span><span id="openRequested"></span>
            </div>
            <div class="col-12 mb-2">
                <span class="fw-semibold">Assigned: </span><span id="openAssigned"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">District: </span><span id="openDistrict"></span>
            </div>
            <hr>
            <h6 class="mb-3 fw-semibold">Do you want to <span class="text-primary">open</span> this ticket?</h6>
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <x-cancel-button>Cancel</x-cancel-button>
                <x-submit-button>Proceed</x-submit-button>
            </div>
        </div>
    </form>
</x-modal>