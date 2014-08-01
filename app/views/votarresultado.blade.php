@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable alert-info">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
        <br/><br/><br/><br/><br/>
        <div id="formInvitar" class="row font-frutiger">
            <div class="text-center text-white col-xs-10 col-xs-offset-1" style="font-size: 1.9em;">
                <br/><br/>
                <b style="font-size: 2em; font-weight: 900;">HOLA!</b>
                <p class="text-black">
                    HAS SIDO <b>VÍCTIMA</b> DEL PODER DE <b>ADICCIÓN</b> DE {{ $nombreAmiga }}
                </p>
                <p>
                   CONTIGO YA SON {{ $totalVictimas }}.
                </p>
            </div>
        </div>
        <br/><br/>
        <p class="text-center text-white">
            <a class="boton salir" href="" onclick="salir()">Chau! ;) <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="30" /></i></a>
        </p>

    <script type="text/javascript">
        function salir() {
            top.location.href = "https://www.facebook.com/pages/Cyzone-Tester/129158347286143?sk=timeline";
        }
    </script>
        
@stop
