@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif

{{ Form::open(["url" => "/inscripcion/save","method" => "post","autocomplete" => "off", "role" => "form"]) }}
    <div class="form-group">
        {{ Form::text("Nombre", Input::old("Nombre"), ["placeholder" => "Nombre", "class" => "form-control"]) }}
    </div>
    {{ Form::submit("Guardar") }}
{{ Form::close() }}

        <form role="form">
          <div class="form-group">
            <input type="text" class="form-control" id="InputNombre" name="InputNombre" placeholder="Nombre">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="InputNombre" name="InputNombre" placeholder="Apellido Paterno">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="InputNombre" name="InputNombre" placeholder="Apellido Materno">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="InputNombre" name="InputNombre" placeholder="País">
          </div>
          <div class="form-group">
            <input type="email" class="form-control" id="InputNombre" name="InputNombre" placeholder="Correo">
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox"> Check me out
            </label>
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>

@stop
