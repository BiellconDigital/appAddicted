@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable text-info">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
        <br/><br/><br/><br/><br/>
        <div id="formInvitar" class="row font-frutiger">
            <div class="text-center text-white col-xs-10 col-xs-offset-1" style="font-size: 1.8em;">
                <br/><br/>
                HOLA!
                <p class="text-black">
                    <b>HAS SIDO VÍCTIMA DEL PODER DE ADDICCIÓN DE {{ $nombreAmiga }}</b>
                </p>
                <p>
                   CONTIGO YA SON {{ $totalVictimas }}.
                </p>
            </div>
        </div>
        <br/><br/>
        <p class="text-center text-white">
            <a class="boton salir" href="" onclick="salir()">Chau! ;)</a>
        </p>

    <script type="text/javascript">
        function salir() {
            top.location.href = "https://www.facebook.com/studiomanda";
        }
    </script>
        
@stop
