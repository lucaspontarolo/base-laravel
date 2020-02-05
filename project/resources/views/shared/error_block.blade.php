<div class="invalid-feedback">
    @if ($errors->has($field))
        {{ $errors->first($field) }}
    @elseif ($required)
        Campo obrigatório!
    @endif
</div>