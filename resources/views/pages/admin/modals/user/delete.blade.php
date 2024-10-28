<x-modal id="deleteUser" title="Delete User Account" size="md">
    <form action="{{ route('shared.manage-users.delete-user') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" id="deleteUserId">
        <p>Are you sure you want to <strong class="text-danger">delete</strong> the account of
            <span class="fw-bold" id="deleteUserName"></span>?
            Once you confirm, the account will be deleted pernamently.
        </p>

        <hr>
        <div class="d-flex justify-content-between gap-2">
            <x-submit-button>Delete</x-submit-button>
            <x-cancel-button>Cancel</x-cancel-button>
        </div>
    </form>
</x-modal>