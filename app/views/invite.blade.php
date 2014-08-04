@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable text-error">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
    <script type="text/javascript">
        https://www.facebook.com/Cyzone-Tester?v=app_102227703153175&app_data=any_string_here
        top.location.href = url_face_tab_app + "&app_data=" + {{ $request_ids }};
    </script>
@stop
