@extends('layouts/layout')
@section('content')
    @if(Session::has('message'))
            <div class="alert alert-dismissable  alert-info">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif
    
    <div class="text-center">
        <br/><br/><br/><br/>
        <a class="boton sendRequest" href="" onclick="reiniciar()">
            Reiniciar
        </a> 
    </div>
    <script type="text/javascript">
        function reiniciar() {
            top.location.href = url_face_tab_app;// "https://www.facebook.com/studiomanda/app_102227703153175";
        }
    </script>
    
@stop
