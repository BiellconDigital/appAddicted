@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable text-error">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
    <script type="text/javascript">
        top.location.href = url_face_tab_app;
    </script>
@stop
