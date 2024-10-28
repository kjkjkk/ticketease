<x-modal id="invalidTicket" title="Invalid Ticket" size="md">
    <form action="{{ route('invalid-ticket') }}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
        <div class="row">
            <input type="hidden" name="ticket_id" id="invalidTicketId">
            <div class="mb-2">
                <span class="fw-semibold">Requestor: </span><span id="invalidRequestorName"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">Ticket Nature: </span><span id="invalidTicketNature"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">Device: </span><span id="invalidTicketDevice"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">Date Requested: </span><span id="invalidDateRequested"></span>
            </div>
            <div class="mb-2">
                <span class="fw-semibold">District: </span><span id="invalidRequestorDistrict"></span>
            </div>
            <hr>
            <div class="col-12 mb-3">
                <label for="invalidReason" class="fw-semibold text-danger">Reason for invalidation:</label>
                <textarea name="invalidReason" id="invalidReason" rows="2" class="form-control border border-dark"
                    required></textarea>
            </div>
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <x-cancel-button>Cancel</x-cancel-button>
                <x-submit-button>Confirm</x-submit-button>
            </div>
        </div>
    </form>
</x-modal>