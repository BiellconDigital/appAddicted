@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif

	<iframe width="560" height="315" src="//www.youtube.com/embed/nQ5bAb3YQ6Y" frameborder="0" allowfullscreen></iframe>

@stop
