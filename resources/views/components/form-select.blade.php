@props(['label', 'name', 'options' => [], 'selected' => null, 'placeholder' => '-- Pilih --', 'required' => false])
<div class="mb-3">
    <label for="{{ $name }}" class="form-label small fw-semibold">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    <select name="{{ $name }}" id="{{ $name }}"
            {{ $attributes->merge(['class' => 'form-select'.($errors->has($name) ? ' is-invalid' : '')]) }}>
        <option value="">{{ $placeholder }}</option>
        {{ $slot }}
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
