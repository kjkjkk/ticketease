<div class="col-12">
    <div class="d-flex justify-content-between">
        <h4 class="fw-bold text-logo-dark">Personal Information</h4>
        <div>
            <input type="checkbox" class="btn-check" id="checkboxPersonalInformation" autocomplete="off">
            <label class="btn btn-sm btn-outline-primary fw-semibold" for="checkboxPersonalInformation"><i
                    class="fi fi-ss-customize-edit"></i>
                Edit Personal Information</label>
        </div>
    </div>
    <form>
        <div class="row my-3">
            <div class="col-12 col-md-6">
                <x-view-input type="text" name="firstname" id="editFirstname" label="FIRSTNAME"
                    value="{{ auth()->user()->firstname}}" />
                @error('firstname')
                <x-error-message>{{ $message }}</x-error-message>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <x-view-input type="text" name="lasstname" id="editLastname" label="LASTNAME"
                    value="{{ auth()->user()->lastname}}" />
                @error('lastname')
                <x-error-message>{{ $message }}</x-error-message>
                @enderror
            </div>
            <div class="col-12 col-md-6">
                <x-view-input type="text" name="contact_number" id="editContactNumber" label="CONTACT NUMBER"
                    value="{{ auth()->user()->contact_number}}" />
                @error('contact_number')
                <x-error-message>{{ $message }}</x-error-message>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="d-none float-end my-2" id="personalInformationButtonContainer">
                <x-submit-button><i class="fi fi-ss-disk me-2"></i>SAVE CHANGES</x-submit-button>
            </div>
        </div>
    </form>
</div>