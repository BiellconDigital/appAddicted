@extends('layouts/layout')

@section('content')
    <br/><br/><br/><br/><br/>
        <div id="formInvitar" class="row">
            <br/><br/><br/><br/>
            <div class="col-xs-12 text-center" style="font-size: 38px;">
                <span class="text-white">LAS NOTIFICACIONES YA HAN SIDO ENVIADAS</span><br/>
                    <span class="text-black">PRONTO SABRÁS<br/>CUÁNTAS VÍCTIMAS</span><br/>
                    <span class="text-black"><b style="font-size: 45px;">HAS SUMADO!</b></span>
            </div>
        </div>

    <div class="text-center">
        <br/><br/>
        <a class="boton" href="{{route('categorias')}}">
            OK
        </a> 
    </div>


@stop
