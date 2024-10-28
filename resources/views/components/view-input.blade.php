<div class="mb-3">
    <div class="d-flex align-items-center justify-content-between gap-3">
        {{-- <small class="fw-semibold mt-2">{{ $label }}</small> --}}
        <label for="{{ $id }}" class="small fw-semibold">{{ $label }}</label>
        <div class="col-8">
            <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" class="form-control text-end"
                style="border: none; background: #fff;" value="{{ $value }}" disabled>
        </div>
    </div>
    <hr class="n-mt-1">
</div>