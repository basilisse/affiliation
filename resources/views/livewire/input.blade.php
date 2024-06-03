<div class="form-group">
  @if($label)
    <label for="{{ $name }}">{{ $label }}</label>
  @endif
  <div class="input-group mb-3">
    <input
        type="{{ $type }}"
        id="{{ $name }}"
        wire:model="{{ $name }}"
        class="form-control {{ $class }}"
        placeholder="{{ $placeholder }}"
        autocomplete="new-password"
        @if($required)
          required
        @endif
    >
    @if($icon)
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="{{ $icon }}"></span>
        </div>
      </div>
    @endif
  </div>
</div>
