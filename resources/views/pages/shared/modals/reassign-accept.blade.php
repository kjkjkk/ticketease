<x-modal id="acceptOrRejectRequest" title="Request to Reassign Details" size="md">
    <form id="reassignForm" method="POST" action="{{ route('shared.my-tickets.submit-reassign') }}">
        @csrf
        @method("PATCH")
        <div class="row">
            <input type="hidden" name="reassign_ticket_id" id="acceptReassignRequestId">
            <input type="hidden" id="ifAcceptedInput" name="if_accepted">
            <div class="col-12 mt-1">
                <h6> Are you sure you want to accept this reassign request?</h6>
            </div>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-between gap-2">
            <button type="button" class="btn btn-danger fw-semibold" onclick="submitForm(0)">Reject Reassign
                Request</button>
            <button type="button" class="btn btn-primary fw-semibold" onclick="submitForm(1)">Accept Reassign
                Request</button>
        </div>
    </form>
    <script>
        function submitForm(value) {
        document.getElementById('ifAcceptedInput').value = value;
        document.getElementById('reassignForm').submit();
    }
    </script>
</x-modal>