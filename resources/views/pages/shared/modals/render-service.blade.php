<x-modal id="renderService" title="Render Service" size="md">
    <form action="{{ route('shared.render-service') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-12 mb-3">
                <input type="hidden" name="ticketID" value="{{ $ticket->id }}">
            </div>
            <div class="col-12 mb-3">
                <span class="fw-semibold">Enter issue found</span>
                <textarea name="issueFound" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-12 mb-3">
                <span class="fw-semibold">Enter rendered service</span>
                <textarea name="serviceRendered" rows="3" class="form-control"></textarea>
            </div>
            <div class="col-12 d-flex justify-content-end gap-2">
                <x-cancel-button>Cancel</x-cancel-button>
                <x-submit-button>Submit</x-submit-button>
            </div>
        </div>
    </form>
</x-modal>