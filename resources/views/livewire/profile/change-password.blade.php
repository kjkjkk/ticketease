<div class="col-12">
    <h4 class="fw-bold text-logo-dark mb-3">Account Settings</h4>
    <div class="row">
        <div class="col-12 col-lg-6 mb-3">
            <form wire:submit.prevent='changePassword'>
                <div class="col-12">
                    {{-- Show alert only if the password was changed --}}
                    @if (session()->has('password_fail') || session()->has('password_success'))
                    <x-alert-message />
                    @endif
                </div>
                <h6 class="fw-semibold text-dark">Change Password</h6>
                <hr>
                <div class="mb-3">
                    <small class="fw-semibold">ENTER CURRENT PASSWORD:</small>
                    <input type="password" class="form-control border-secondary" wire:model='current_password'>
                    @error('current_password')
                    <small class="fw-semibold text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <small class="fw-semibold">ENTER NEW PASSWORD:</small>
                    <input type="password" class="form-control border-secondary" wire:model='new_password'>
                    @error('new_password')
                    <small class="fw-semibold text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <small class="fw-semibold">ENTER NEW PASSWORD CONFIRMATION:</small>
                    <input type="password" class="form-control border-secondary" wire:model='new_password_confirmation'>
                    @error('new_password_confirmation')
                    <small class="fw-semibold text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <x-submit-button><i class="fi fi-ss-disk me-2"></i>Change password</x-submit-button>
                </div>
            </form>
        </div>
        <div class="col-12 col-lg-6 mb-3">
            <form wire:submit.prevent='changeUsername'>
                <div class="col-12">
                    {{-- Show alert only if the username was changed --}}
                    @if (session()->has('username_fail') || session()->has('username_success'))
                    <x-alert-message />
                    @endif
                </div>
                <h6 class="fw-semibold text-dark">Change Username</h6>
                <hr>
                <div class="mb-3">
                    <small class="fw-semibold">CURRENT USERNAME:</small>
                    <input type="text" class="form-control border-secondary" value="{{ auth()->user()->username }}"
                        readonly>
                </div>
                <div class="mb-3">
                    <small class="fw-semibold">ENTER NEW USERNAME:</small>
                    <input type="text" class="form-control border-secondary" wire:model='new_username'>
                    @error('new_username')
                    <small class="fw-semibold text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <x-submit-button><i class="fi fi-ss-disk me-2"></i>Change username</x-submit-button>
                </div>
            </form>
        </div>
    </div>
</div>