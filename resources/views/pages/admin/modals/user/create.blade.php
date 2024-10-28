<x-modal id="createUser" title="Add New User" size="md">
    <form action="{{ route('shared.manage-users.store')}}" method="POST" autocomplete="off"
        enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-6">
                <x-input type="text" name="firstname" label="First Name" placeholder="First name"
                    arialabel="First name" />
            </div>
            <div class="col-6">
                <x-input type="text" name="lastname" label="Last Name" placeholder="Last name" arialabel="Last name" />
            </div>

        </div>
        <div class="row mb-3">
            <div class="col">
                <x-label for="role">Role</x-label>
                <select name="role" id="role" class="form-control" onchange="toggleSignatureField()" required>
                    <option value="">Select Role</option>
                    @if(auth()->user()->role == "Admin")
                    <option value="Technician">Technician</option>
                    @endif
                    <option value="Requestor">Requestor</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <x-label for="signature">Signature</x-label>
                <input name="signature" accept="image/png, image/jpg" id="signature" type="file" class="form-control">
            </div>
        </div>

        <hr>
        <div class="d-flex justify-content-end gap-2">
            <x-cancel-button>Cancel</x-cancel-button>
            <x-submit-button>Confirm</x-submit-button>
        </div>
    </form>
</x-modal>