@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
            <div class="alert alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif
    <div class="row">
        <div class="col-xs-12">
            <h3>Seleccionar 3 amigos</h3>
            <br/>
        </div>
        @foreach($user_friends as $key => $friend)
        <div class="col-xs-4">
            <div class="col-xs-5">
                <img src="{{ $friend->picture->data->url }}" class="img-responsive img-rounded" />
                <br/><br/>
            </div>
            <div class="col-xs-7">
                    <h5>{{ $friend->name }}</h5> 
            </div>
        </div>
        @endforeach
    </div>
@stop
