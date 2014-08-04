@extends('layouts/layout')

@section('content')
    <br/><br/><br/><br/><br/>
        <div id="formInvitar" class="row">
            <br/><br/><br/><br/>
            <div class="col-xs-12 text-center" style="font-size: 35px;">
                <span class="text-white">SE REALIZÓ EL ENVÍO</span><br/>
                    <span class="text-black">PRONTO SABRÁS<br/>CUALES SON</span><br/>
                    <span class="text-black"><b style="font-size: 45px;">TUS VÍCTIMAS</b></span>
            </div>
        </div>

    
    <div class="text-center">
        <br/><br/>
        <a class="boton" href="{{route('categorias')}}">
            Listo <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="30" /></i>
        </a> 
    </div>


@stop
