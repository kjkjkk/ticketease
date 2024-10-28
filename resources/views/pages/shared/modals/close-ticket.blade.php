<!-- Close Ticket Modal -->
<x-modal id="closeTicket" title="Close Ticket" size="md">
    <form action="{{ route('close-ticket') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <h6>Are you sure you want to <strong>close</strong> this ticket? This action cannot be undone.</h6>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Submit</x-submit-button>
        </div>
    </form>
</x-modal>