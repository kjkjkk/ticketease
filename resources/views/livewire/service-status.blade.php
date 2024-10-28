<div>
    <fieldset>
        <h6 class="fw-semibold">Ticket current service status</h6>
        <div class="row">
            @foreach ($service_statuses as $key => $status)
            <div class="col-12 mb-1">
                <input type="radio" id="status_{{ $key }}" name="service_status" wire:model="selectedStatus"
                    wire:change="updateServiceStatus" value="{{ $status }}" {{ $serviceStatus==$status ? 'checked' : ''
                    }} />
                <label for="status_{{ $key }}">{{ $status }}</label>
            </div>
            @endforeach
        </div>
    </fieldset>
    @if (session()->has('message'))
    <small class="fw-semibold text-success">
        {{ session('message') }}
    </small>
    @endif
</div>