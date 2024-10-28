<!-- To CITC Ticket Modal -->
<x-modal id="toCitc" title="To CITC" size="md">
    <form action="{{ route('to-citc-ticket') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <h6>Are you sure you want to transfer this ticket <strong class="text-warning">to CITC</strong>? This will
                assign the ticket to the CITC team for further action.</h6>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Submit</x-submit-button>
        </div>
    </form>
</x-modal>