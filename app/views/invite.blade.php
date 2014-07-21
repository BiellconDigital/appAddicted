@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
    <script type="text/javascript">
        top.location.href = "https://www.facebook.com/studiomanda/app_1483842561857563";
    </script>
@stop
