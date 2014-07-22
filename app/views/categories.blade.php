@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('message')}}
        </div>
    @endif
    <div class="text-center">
        <img src="{{asset('img/logo-inicio.png')}}" width="150"/>
        <br/><br/><br/><br/><br/>
    </div>
    
    <div class="row">
        @foreach($categories as $key => $category)
        <div class="col-xs-4" >
                <a href="{{url('categorias/amigos/' . $category->id)}}">
                    <img src="{{asset('img/' . $category->photo)}}" class="img-responsive"/>
                </a><br/>
        </div>
        @endforeach
        
    </div>
    
    <div class="">
        <br/><br/><br/><br/><br/><br/>
        <br/><br/><br/><br/><br/>
        <a class="boton-small" href="{{route('categorias')}}">
            Categorias <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="20" /></i>
        </a> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="boton-small" href="{{route('ranking')}}">
            Ranking <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="20" /></i>
        </a> 
    </div>

@stop
