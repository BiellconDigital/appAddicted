@extends('layouts/layout')

@section('content')
	@if($message)
		<div class="alert alert-dismissable alert-danger">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ $message }}
		</div>
	@endif
        
@stop
