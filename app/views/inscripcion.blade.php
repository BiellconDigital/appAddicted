@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-dismissable alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('message')}}
        </div>
    @endif
    <br/>    <br/>
    <div class="text-center">
        <img src="{{asset('img/titulo-registro.png')}}" />
    </div>
    <br/>
    {{ Form::model($user, array('route' => array('inscripcion.update', $user->id), "role" => "form")) }}
        <div id="formInscripcion">
            
            {{ Form::token(); }}
            <div class="form-group">
                {{ Form::text("form_nombre", Input::old("form_nombre"), ["placeholder" => "Nombre", "class" => ""]) }}
            </div>
            <div class="form-group">
                {{ Form::text("form_apellido", Input::old("form_apellido"), ["placeholder" => "Apellidos", "class" => ""]) }}
            </div>
            <div class="">
                {{ Form::label('form_fecha_nacimiento', 'Fecha de Nacimiento', array('for' => 'form_fecha_nacimiento')) }}
            </div>
            <div class="form-group">
                <div class="input-group date">
                    {{ Form::text( "form_fecha_nacimiento", Input::old("form_fecha_nacimiento"), ["class" => "form-control"]) }}
                  <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div>
            </div>
            
            <div class="form-group">
		{{ Form::select('form_pais', $paises, Input::old("form_pais"), ["placeholder" => "País", "class" => "form-control selectAddicted"]) }}
            </div>
            <div class="form-group">
                {{ Form::text("form_email", Input::old("form_email"), ["placeholder" => "Correo", "class" => ""]) }}
            </div>
            <div class="form-group">
                <div class="checkbox text-white">
                    {{ Form::checkbox("form_acepta_term", Input::old("form_acepta_term"), ["placeholder" => "Nombre", "class" => "form-control"]) }}
                    He leído los <a href="/html/files/Terminos y condiciones.pdf" target="_blank">Términos y condiciones</a> de uso y estoy de acuerdo.
                </div>
            </div>
            {{ Form::hidden("inscrito", 1) }}
        </div>
        <div class="form-group text-center">
            <br/><br/>
            <button type="submit" class="boton text-center">Continúa</button>
        </div>
    {{ Form::close() }}

    <script type="text/javascript">
        jQuery(document).ready(function()
        {
            $('.input-group.date').datepicker({
                format: "dd-mm-yyyy",
                startView: 2,
                language: "es",
                autoclose: true
            });
        });
    </script>
@stop
