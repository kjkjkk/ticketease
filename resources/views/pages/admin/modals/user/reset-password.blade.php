<x-modal id="resetPassword" title="Reset Password" size="md">
    <form action="{{ route('shared.manage-users.reset-password') }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Hidden input field for user ID -->
        <input type="hidden" name="id" id="resetPasswordUserId">

        <p>Are you sure you want to reset the password for <span class="fw-bold" id="resetPasswordUserName"></span>?</p>

        <hr>
        <div class="d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Confirm</x-submit-button>
        </div>
    </form>
</x-modal>