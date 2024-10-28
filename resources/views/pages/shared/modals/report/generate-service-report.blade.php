<x-modal id="confirmGenerateReport" title="Generate Service Report" size="md">
    <form action="{{ route('browserpdf') }}" method="POST" target="_blank">
        @csrf
        <div class="row">
            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

            <div class="d-flex align-items-center gap-2 mb-3">
                <input type="checkbox" name="showVerifyBy" style="width: 20px; height: 20px;">
                <x-label class="ms-2">Show <span class="text-primary">VERIFY BY</span></x-label>
            </div>
            <h6 class="fw-semibold">Please make sure to review the ticket and service details before generating the
                service report.</h6>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-between gap-2">
            <button type="submit" class="btn btn-logo fw-semibold" data-bs-dismiss="modal">Submit</button>
            <x-cancel-button>Cancel</x-cancel-button>
        </div>
    </form>
</x-modal>