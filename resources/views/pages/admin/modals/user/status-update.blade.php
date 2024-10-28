<x-modal id="userStatus" title="{{ $user->user_status === 'Active' ? 'Deactivate User' : 'Reactivate User' }}"
    size="md">
    <form action="{{ route('shared.manage-users.update-user-status') }}" method="POST">
        @csrf
        @method('PATCH')

        <input type="hidden" name="id" id="userStatusUserId">
        <p>Are you sure you want to <span class="fw-bold text-logo-dark" id="accountStatus"></span> user
            <span class="fw-bold" id="updateStatusUserName"></span>?
            The account and access will be <span id="accountState"></span>.
        </p>

        <hr>
        <div class="d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Confirm</x-submit-button>
        </div>
    </form>
</x-modal>