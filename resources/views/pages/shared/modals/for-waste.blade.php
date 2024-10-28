<!-- For Waste Ticket Modal -->
<x-modal id="toWaste" title="For Waste" size="md">
    <form action="{{ route('for-waste-ticket') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <h6>Are you sure you want to update this ticket's status to <strong class="text-danger">For Waste</strong>?
                This action is irreversible.</h6>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Submit</x-submit-button>
        </div>
    </form>
</x-modal>