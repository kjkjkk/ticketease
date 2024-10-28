<x-modal id="invalid" title="Invalid Ticket" size="md">
    <form action="{{ route('invalid-ticket') }}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
        <div class="row">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <h6>Are you sure you want to <strong class="text-danger">invalid</strong> this ticket?
                This action is irreversible.</h6>
            <hr>
            <div class="col-12 mb-3">
                <label for="invalidReason" class="fw-semibold">Reason for invalidation:</label>
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