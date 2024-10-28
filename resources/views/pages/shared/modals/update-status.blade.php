<x-modal id="updateTicketStatus" title="Update Ticket Status" size="md">
    <form action="{{ route('shared.update-status') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
            <div class="col-12 mb-3">
                <x-label>Select and update ticket status</x-label>
                <select name="new_status" class="form-control border-secondary">
                    @foreach (\App\Enum\UpdateStatus::cases() as $status)
                    <option value="{{ $status->id() }}" {{ $ticket->status_id === $status->id() ? "selected" : "" }} >
                        {{ $status->value() }}
                    </option>
                    @endforeach
                </select>
            </div>
            <hr>
            <div class="d-flex justify-content-between gap-2">
                <x-submit-button>Confirm</x-submit-button>
                <x-cancel-button>Cancel</x-cancel-button>
            </div>
        </div>
    </form>
</x-modal>