<div class="mb-3">
    <x-label for="{{ $name }}">{{ $label }}</x-label>
    <textarea name="{{ $name }}" rows="{{ $rows }}" class="form-control"
        placeholder="{{ $placeholder }}">{{ old($name) }}</textarea>
    @error($name)
    <x-error-message>{{ $message }}</x-error-message>
    @enderror
</div>
{{-- name, label, placeholder, rows --}}