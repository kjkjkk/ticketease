<x-modal id="cancelTemporaryAdminRole" title="Cancel Temporary Admin" size="md">
    <form action="{{ route('admin.cancel-temporary-admin')}}" method="POST" autocomplete="off">
        @csrf
        @method('POST')
        <input type="hidden" name="technician_id" id="temporaryAdminID">
        <div class="row">
            <div class="col-12">
                Are you sure you want to <strong class="text-danger">cancel</strong> <span class="fw-bold"
                    id="temporaryAdminName"></span>
                temporary admin role?
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <x-submit-button>Confirm</x-submit-button>
            <x-cancel-button>Cancel</x-cancel-button>
        </div>
    </form>
</x-modal>