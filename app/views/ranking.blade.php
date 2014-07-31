@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
            <div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif

    <div class="text-center text-fucsia">
        <h4 style="margin-bottom: 7px;">SI QUEDAS ENTRE LAS CINCO PRIMERAS,</h4>
        <h3 class="text-white" style="margin-top: 0;">
                GANARÁS UN SITIO EN UN HANGOUT EXCLUSIVO CON <span style="font-weight: bolder;">MALUMA</span>
        </h3>
    </div>
    <br/>

        <div id="formInvitar" class="row">
            
            <div class="col-xs-12 text-center text-white">
                <h4>LAS MÁS ADICTIVAS</h4><br/>
            </div>
            
            <div class="panel-amigos col-xs-12 text-white">
                @foreach($participants as $key => $participant)
                <div class="col-xs-6 item-amigos">
                    <ul class="list-inline lista-amigos">
                      <li><img src="{{ $participant->photo }}" class="" width="44"/>&nbsp;&nbsp; </li>
                      <li style="max-width: 117px;">
                          {{ $participant->form_nombre }} {{ $participant->form_apellido }}
                          <br/><span class="text-black h4"><b>{{ $participant->votes }} víctimas</b></span>
                      </li>
                    </ul>     
                </div>
                @endforeach
            </div>
        </div>

    <div class="text-right font-frutiger small" style="width: 83%;">
        <br/>
        <span class="text-white">TIENES HASTA EL </span><span class="text-fucsia"> 30 DE AGOSTO</span>
    </div>

    <div class="text-center">
        <br/><br/><br/>
        <a class="boton-small" href="{{route('categorias')}}">
            Reportar más víctimas
        </a> 
    </div>

@stop    
