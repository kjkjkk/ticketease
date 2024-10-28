<x-modal id="reassignTicket" title="Request to Reassign Ticket" size="md">
    <form action="{{ route('shared.my-tickets.reassign-ticket') }}" method="POST">
        @csrf
        @method("POST")
        <div class="row">
            <input type="hidden" name="ticket_id" id="reassignTicketId">
            <input type="hidden" name="from_technician" value="{{ auth()->user()->id }}">
            <div class="col-12 d-flex">
                <h6 class="fw-semibold">Ticket ID: <span id="displayTicketId"></span></h6>
            </div>
            <div class="col-12 d-flex">
                <h6 class="fw-semibold">Requestor: <span id="displayRequestor"></span></h6>
            </div>
            <div class="col-12 d-flex">
                <h6 class="fw-semibold">Ticket Nature: <span id="displayTicketNature"></span></h6>
            </div>
            <div class="col-12 my-3">
                <x-label>Select technician to reassign to</x-label>
                <select name="to_technician" class="form-control border-secondary">
                    @foreach ($technicians as $technician)
                    @if($technician->id != auth()->user()->id)
                    <option value="{{ $technician->id }}">{{ $technician->firstname . " " . $technician->lastname }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-between gap-2">
            <x-submit-button>Submit</x-submit-button>
            <x-cancel-button>Cancel</x-cancel-button>
        </div>
    </form>
</x-modal>