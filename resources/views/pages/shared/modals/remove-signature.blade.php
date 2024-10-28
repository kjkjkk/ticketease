<!-- Close Ticket Modal -->
<x-modal id="removeSignature" title="Remove Signature" size="md">
    <form action="{{ route('remove-signature') }}" method="POST">
        @csrf
        <div class="row">
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <h6 class="fw-bold">Are you sure you want to <span class="text-danger">remove</span> your signature?</h6>
        </div>
        <hr>
        <div class="col-12 d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Submit</x-submit-button>
        </div>
    </form>
</x-modal>