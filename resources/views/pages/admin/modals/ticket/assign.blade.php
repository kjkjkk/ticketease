<x-modal id="assignTicket" title="Assign Ticket" size="md">
    <form action="{{ route('admin.ticket-request.assign') }}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
        <div class="row">
            <input type="hidden" name="ticket_id" id="assignTicketId">
            <div class="mb-2">
                <span class="fw-semibold">Requestor: </span><span id="assignRequestorName"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">Ticket Nature: </span><span id="assignTicketNature"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">Device: </span><span id="assignTicketDevice"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">Date Requested: </span><span id="assignDateRequested"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">District: </span><span id="assignRequestorDistrict"></span>
            </div>
            <hr>
            <div class="col-12 mb-3">
                <x-label>Assign To</x-label>
                <x-technician-dropdown />
            </div>
            <div class="d-flex align-items-center justify-content-end gap-2 mb-3">
                <input type="checkbox" name="if_priority" style="width: 20px; height: 20px;">
                <x-label class="ms-2">Check if priority</x-label>
            </div>
            <input type="hidden" name="assigned_by" class="form-control" value="{{ Auth::id() }}">
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <x-cancel-button>Cancel</x-cancel-button>
                <x-submit-button>Confirm</x-submit-button>
            </div>
        </div>
    </form>
</x-modal>