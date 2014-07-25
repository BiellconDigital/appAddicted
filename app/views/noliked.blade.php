@extends('layouts/layout')
@section('content')
    <style>
        body {
            background-image: url({{ URL::asset('img/bg-inicio.jpg') }});
        }    
    </style>
    @if(Session::has('message'))
            <div class="alert alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif
@stop
