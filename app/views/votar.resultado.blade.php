@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
        
        <div class="text-center">
            HOLA!
            <p>
               HAS SIDO VICTIMA DEL PODER DE ADDICCIÓN DE {{ $nombreAmiga }}
            </p>
            <p>
               CONTIGO YA SON {{ $totalVictimas }}
            </p>
        </div>
        
        <p class="text-center">
            <a class="boton salir" href="" onclick="salir()">Chau! ;)</a>
        </p>

    <script type="text/javascript">
        function salir() {
            top.location.href = "https://www.facebook.com/studiomanda";
        }
    </script>
        
@stop
