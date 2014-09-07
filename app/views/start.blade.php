{{-- SETUP PAGE --}}
@if(isset($page))
	
	{{-- LAYOUT --}}
	@if(isset($page->layout))
		@if (\File::exists(app_path().'\\views\\'.str_replace(['.'], '\\', $page->layout).'.blade.php'))
			@extends($page->layout)
		@endif
	@endif

	{{-- LANG --}}
	@if(isset($page->lang))
		@section('lang')
			{{ $page->lang }}
		@endsection
	@endif

	{{-- DESCRIPTION --}}
	@if(isset($page->description))
		@section('description')
			{{ $page->description }}
		@endsection
	@endif

	{{-- TITLE --}}
	@if(isset($page->title))
		@section('title')
			{{ $page->title }}
		@endsection
	@endif

	{{-- MENU --}}
	@if(isset($page->menu))
		@if (\File::exists(app_path().'\\views\\'.str_replace(['.'], '\\', $page->menu).'.blade.php'))
			@include($page->menu)
		@endif
	@endif

	{{-- APP --}}
	@if(isset($page->app))
		@if (\File::exists(app_path().'\\views\\'.str_replace(['.'], '\\', $page->app).'.blade.php'))
			@include($page->app)
		@endif
	@endif
	
@endif