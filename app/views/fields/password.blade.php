<div class="line-form">
	<div class="sub-line">
		{{ Form::label($name, $label, ['class' => 'pointer', 'for' => $name]) }}
		<a class="right" href="{{ route('restore') }}">Olvidaste tu {{ $label }}?</a>
	</div>
	{{ $control }}
    @if ($error)
        <p class="error-message">{{ $error }}</p>
    @endif
</div>