<div class="mb-3">
    <x-label for="{{ $name }}">{{ $label }}</x-label>
    <select name="{{ $name }}" class="form-control">
        <option value="" disabled selected>{{ $selected }}</option>
        @foreach ($items as $item)
        <option value="{{ $item->id }}" {{ old($name)==$item->id ? 'selected' : ''}}>
            {{ $item->$render }}
        </option>
        @endforeach
    </select>
    @error($name)
    <x-error-message>{{ $message }}</x-error-message>
    @enderror
</div>