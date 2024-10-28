<x-modal id="assignAsTemporaryAdmin" title="Assign as temporary admin" size="md">
    <form action="{{ route('admin.assign-temporary-admin')}}" method="POST" autocomplete="off">
        @csrf
        @method('POST')

        <div class="row">
            <div class="col-12 mb-3">
                <x-label for="technician">
                    Select technician
                </x-label>
                <select name="technician_id" id="technician" class="form-control">
                    @foreach ($technicians as $technician)
                    <option value="{{ $technician->id }}">
                        {{ $technician->firstname . ' ' . $technician->lastname }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between">
            <x-submit-button>Confirm</x-submit-button>
            <x-cancel-button>Cancel</x-cancel-button>
        </div>
    </form>
</x-modal>