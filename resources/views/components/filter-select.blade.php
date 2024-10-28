<div>
    <small class="fw-semibold">{{ $label }}</small>
    <select class="form-control border-2 border-success" id="{{ $id }}" onkeyup="{{ $function }}">
        <option value="">All</option>
        {{ $slot }}
    </select>
</div>