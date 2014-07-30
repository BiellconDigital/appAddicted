@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-dismissable alert-info">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('message')}}
        </div>
    @endif
    <div class="text-center">
        <br/><br/>
        <img src="{{asset('img/titulo-categorias.png')}}"/>
        <br/><br/><br/><br/><br/><br/>
    </div>
    
    <div class="row" style="width: 88%;margin: auto;">
        
        @foreach($categories as $key => $category)
        <div class="col-xs-6" style="height: 107px;margin-bottom: 14px;">
                <a href="{{url('categorias/amigos/' . $category->id)}}">
                    <img src="{{asset('img/' . $category->photo)}}" class="img-responsive"/>
                </a>
        </div>
        @endforeach
        
    </div>
    
    <div class="text-center">
        <br/><br/><br/>
        <a class="boton-small" href="{{route('ranking')}}">
            Mira el Ranking
        </a> 
    </div>

    
@stop
