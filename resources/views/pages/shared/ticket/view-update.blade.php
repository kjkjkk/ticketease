<div class="col-12 d-flex justify-content-between gap-2">
    <h5 class="fw-semibold mt-2">
        Ticket Details
    </h5>
    @if ($ticket->status_id == 1 || $ticket->ticketAssign->technician_id == Auth::id())
    <div>
        <input type="checkbox" class="btn-check" id="checkboxTicketDetails" autocomplete="off">
        <label class="btn btn-outline-primary fw-semibold" for="checkboxTicketDetails"><i
                class="fi fi-ss-customize-edit"></i>
            Edit Ticket Details</label>
    </div>
    @endif

</div>
<hr>
<form action="{{ route('ticket.update')}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mt-2">
        <input type="hidden" name="id" id="id" value="{{ $ticket->id }}">
        @error('id')
        <x-error-message>{{ $message }}</x-error-message>
        @enderror
        <div class="col-12 col-md-6">
            <x-view-select name="ticket_nature_id" id="editTicketNature" label="TICKET NATURE" :items="$ticketNatures"
                selected="{{ $ticket->ticket_nature_id }}" render="ticket_nature_name" />
            @error('ticket_nature_id')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12 col-md-6">
            <x-view-select name="district_id" id="editDistrict" label="DISTRICT" :items="$districts"
                selected="{{ $ticket->district_id }}" render="district_name" />
            @error('district_id')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12 col-md-6">
            <x-view-input type="text" name="department" id="editDepartment" label="DEPARTMENT"
                value="{{ $ticket->department}}" />
            @error('department')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12 col-md-6">
            <x-view-select name="device_id" id="editDevice" label="DEVICE" :items="$devices"
                selected="{{ $ticket->device_id }}" render="device_name" />
            @error('device_id')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12 col-md-6">
            <x-view-input type="text" name="brand" id="editBrand" label="BRAND" value="{{ $ticket->brand }}" />
            @error('brand')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12 col-md-6">
            <x-view-input type="text" name="model" id="editModel" label="MODEL" value="{{ $ticket->model }}" />
            @error('model')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12 col-md-6">
            <x-view-input type="text" name="property_no" id="editPropertyNo" label="PROPERTY NO."
                value="{{ $ticket->property_no }}" />
            @error('property_no')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12 col-md-6">
            <x-view-input type="text" name="serial_no" id="editSerialNo" label="SERIAL NO."
                value="{{ $ticket->serial_no }}" />
            @error('serial_no')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12">
            <x-view-textarea name="details" id="editDetails" label="DETAILS" rows="2" value="{{ $ticket->details }}" />
            @error('details')
            <x-error-message>{{ $message }}</x-error-message>
            @enderror
        </div>
        <div class="col-12">
            <div class="d-none float-end my-2" id="ticketDetailsButtonContainer">
                <x-submit-button><i class="fi fi-ss-disk me-2"></i>SAVE CHANGES</x-submit-button>
            </div>
        </div>
    </div>
</form>