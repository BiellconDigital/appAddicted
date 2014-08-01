@extends('layouts/admin')
@section('content')
    @if(Session::has('message'))
            <div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif
    
    <br/><br/>
    <div style="margin: auto; width: 460px;">
        <div class="panel panel-danger">
          <div class="panel-title panel-heading">Descarga de Reporte de Participantes</div>
          <div class="panel-body">
            {{ Form::open(array('route' => 'reportes.participantes', "role" => "form", "class" => "form-horizontal")) }}
                  <div class="form-group">
                    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        {{ Form::password("inputPassword", "", ["id" => "inputPassword", "class" => "form-control"]) }}
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-danger">
                            <span class="glyphicon glyphicon-download"></span> Descargar
                        </button>
                    </div>
                  </div>
            {{ Form::close() }}        
          </div>

        </div>
        
    </div>
    
@stop
