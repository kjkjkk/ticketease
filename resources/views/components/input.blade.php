<div class="mb-3">
    <x-label for="{{ $name }}">{{ $label }}</x-label>
    <input name="{{ $name }}" id="{{ $name }}" type="{{ $type }}" class="form-control" placeholder="{{ $placeholder }}"
        aria-label="{{ $arialabel }}" value="{{ old($name) }}">
    @error($name)
    <x-error-message>{{ $message }}</x-error-message>
    @enderror
</div>