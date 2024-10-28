<div class="mb-3">
    <div class="d-flex align-items-center justify-content-between gap-3">
        <small class="fw-semibold mt-2">{{ $label }}</small>
        <div class="col-8">
            <select name="{{ $name }}" id="{{ $id }}" class="form-control text-end"
                style="border: none; background: #fff;" disabled>
                @foreach ($items as $item)
                <option value="{{ $item->id }}" {{ $item->id == $selected ? 'selected' : ''}}>
                    {{ $item->$render }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <hr class="n-mt-1">
</div>