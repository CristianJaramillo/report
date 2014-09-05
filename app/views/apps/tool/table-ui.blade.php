{{-- TITLE --}}
@section('title')
	Table - UI
@endsection
{{-- TITLE --}}
@section('after-links')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/tools/table-ui/table-ui.css') }}"/>
@endsection
{{-- APLICATION --}}
@section('app')
	<div id="table-ui"></div>
@endsection
{{-- SCRIPT --}}
@section('after-scripts')
	<script src="{{ asset('js/tools/table-ui.js') }}" type="text/javascript"></script>
@endsection
{{-- ACTION SCRIPT --}}
@section('action-script')
	$('#wrapper').startUX({
		"modal": true
	});
	$('#table-ui').tableUI({
		"_token": "{{ csrf_token() }}",
		"action": "show",
		"dialog-table": false,
		"menu-table":   false,
		"url":          "ajax"
	});
@endsection