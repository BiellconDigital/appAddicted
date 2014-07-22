@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('message')}}
        </div>
    @endif
    <img src="{{asset('img/logo-thums.png')}}" />
    
    {{ Form::model($user, array('route' => array('inscripcion.update', $user->id), "role" => "form")) }}
        <div id="formInscripcion">
            {{ Form::token(); }}
            <div class="form-group">
                {{ Form::text("form_nombre", Input::old("form_nombre"), ["placeholder" => "Nombre", "class" => ""]) }}
            </div>
            <div class="form-group">
                {{ Form::text("form_ape_paterno", Input::old("form_ape_paterno"), ["placeholder" => "Apellido Paterno", "class" => ""]) }}
            </div>
            <div class="form-group">
                {{ Form::text("form_ape_materno", Input::old("form_ape_materno"), ["placeholder" => "Apellido Materno", "class" => ""]) }}
            </div>
            <div class="">
                {{ Form::label('form_fecha_nacimiento', 'Fecha de Nacimiento', array('for' => 'form_fecha_nacimiento')) }}
            </div>
            <div class="form-group">
                {{ Form::input('date', "form_fecha_nacimiento", Input::old("form_fecha_nacimiento"), ["class" => ""]) }}
            </div>
            <div class="form-group">
                {{ Form::text("form_pais", Input::old("form_pais"), ["placeholder" => "País", "class" => ""]) }}
            </div>
            <div class="form-group">
                {{ Form::text("form_email", Input::old("form_email"), ["placeholder" => "Correo", "class" => ""]) }}
            </div>
            <div class="checkbox">
                {{ Form::checkbox("form_acepta_term", Input::old("form_acepta_term"), ["placeholder" => "Nombre", "class" => "form-control"]) }}
                He leido las instrucciones. los Terminos de uso. las politicas de uso de cyzone y estoy de acuerdo
            </div>
            {{ Form::hidden("inscrito", 1) }}
        </div>
        <div class="form-group text-center">
            <br/><br/>
            <button type="submit" class="boton text-center">Guardar <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="30" /></i></button>
        </div>
    {{ Form::close() }}


@stop
