@extends('layouts/layout')
@section('content')
    @if(Session::has('message'))
            <div class="alert alert-dismissable alert-danger">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif
        
    <div class="text-center">
        <br/><br/><br/><br/>
        <a class="boton sendRequest" href="" onclick="salir()">
            Chau! :) <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="20" /></i>
        </a> 
    </div>
    <script type="text/javascript">
        function salir() {
            top.location.href = url_face_page;
        }
    </script>
    
@stop
