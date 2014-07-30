@extends('layouts/layout')

@section('content')
    <br/><br/><br/>
    <br/><br/><br/>
    @if(Session::has('message'))
        <div class="text-center h3 text-white row">
            <div class="col-xs-10 col-xs-offset-1">
                {{ Session::get('message')}}
            </div>
        </div>
    @endif
    
    <div class="text-center">
        <br/><br/><br/>
        <a class="boton" href="{{route('categorias')}}">
            Listo!
        </a> 
    </div>


@stop
