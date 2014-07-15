@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          {{ Session::get('message')}}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-5 col-sm-offset-7 col-xs-5 col-xs-offset-7">
            <div class="thumbnail" id="formInscripcion">
            {{ Form::model($user, array('route' => array('inscripcion.update', $user->id), , "role" => "form")) }}
                {{ Form::hidden("inscrito", "true")) }}
                {{ Form::token(); }}
                <div class="form-group">
                    {{ Form::text("form_nombre", Input::old("form_nombre"), ["placeholder" => "Nombre", "class" => "form-control"]) }}
                </div>
                <div class="form-group">
                    {{ Form::text("form_ape_paterno", Input::old("form_ape_paterno"), ["placeholder" => "Apellido Paterno", "class" => "form-control"]) }}
                </div>
                <div class="form-group">
                    {{ Form::text("form_ape_materno", Input::old("form_ape_materno"), ["placeholder" => "Apellido Materno", "class" => "form-control"]) }}
                </div>
                <div class="form-group">
                    {{ Form::text("form_pais", Input::old("form_pais"), ["placeholder" => "País", "class" => "form-control"]) }}
                </div>
                <div class="form-group">
                    {{ Form::text("form_email", Input::old("form_email"), ["placeholder" => "Correo", "class" => "form-control"]) }}
                </div>
                <div class="checkbox">
                  <label>
                    {{ Form::checkbox("form_acepta_term", Input::old("form_acepta_term"), ["placeholder" => "Nombre", "class" => "form-control"]) }}
                    He leido las instrucciones. los Terminos de uso. las politicas de uso de cyzone y estoy de acuerdo
                    </label>
                </div>
                <div class="form-group text-center">
                    {{ Form::submit("Guardar", ["class" => "btn btn-default text-center"]) }}
                </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>


@stop
