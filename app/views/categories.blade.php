@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('message')}}
        </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <h3>Seleccionar una categoria</h3>
            <br/>
        </div>
        
        @foreach($categories as $key => $category)
        <div class="col-xs-4">
            <div class="col-xs-5">
                <img src="img/{{ $category->photo }}" class="img-responsive img-rounded" />
                <br/><br/>
            </div>
            <div class="col-xs-7">
                <a href="{{url('categorias/amigos/' . $category->id)}}">
                    <h4>{{ $category->name }}</h4> 
                </a>
            </div>
        </div>
        @endforeach
    </div>
    

@stop
