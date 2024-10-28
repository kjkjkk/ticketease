<!-- Close Ticket Modal -->
<x-modal id="changeSignature" title="Change Signature" size="md">
    <form action="{{ route('change-signature') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <div class="form-group">
                <label for="newSignature" class="fw-semibold">New signature</label>
                <input type="file" class="form-control border-secondary" name="signature" id="newSignature">
            </div>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Submit</x-submit-button>
        </div>
    </form>
</x-modal>