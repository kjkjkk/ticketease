<x-modal id="pendingReassignRequest" title="Request to Reassign Details" size="md">
    <form action="{{ route('shared.my-tickets.cancel-reassign-ticket') }}" method="POST">
        @csrf
        @method("POST")
        <div class="row">
            <input type="hidden" name="reassign_ticket_id" id="viewReassignTicketId">
            <div class="col-12 d-flex">
                <h6><strong>Ticket ID:</strong> <span id="displayReassignTicketId"></span></h6>
            </div>
            <div class="col-12 d-flex">
                <h6><strong>Requestor:</strong> <span id="displayReassignRequestor"></span></h6>
            </div>
            <div class="col-12 d-flex">
                <h6><strong>Ticket Nature:</strong> <span id="displayReassignTicketNature"></span></h6>
            </div>
            <div class="col-12 d-flex">
                <h6><strong>Date requested:</strong> <span id="displayReassignDateRequested"></span></h6>
            </div>
            <hr>
            <div class="col-12 mt-1 mb-3">
                <h6 class="">Your request to reassign this ticket to <span class="fw-bold"
                        id="displayToTechnician"></span>
                    is pending.
                </h6>
            </div>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-between gap-2">
            <button type="submit" class="btn btn-danger fw-bold">Cancel Reassign Request</button>
            <x-cancel-button>Close</x-cancel-button>
        </div>
    </form>
</x-modal>