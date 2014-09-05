<div class="inline-form">
	{{ Form::label($name, $label, ['class' => 'pointer', 'for' => $name]) }}
    {{ $control }}
    @if ($error)
        <p class="error-message">{{ $error }}</p>
    @endif
</div>