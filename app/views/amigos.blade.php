@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
            <div class="alert alert-dismissable alert-info">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif
    <div class="text-center">
        <br/>
        <img src="{{asset('img/titulo-escoge-victimas.png')}}" />
        <br/><br/>
    </div>


    {{ Form::open(array('route' => array('categorias.friends', $idCate), 'id' => 'formVictims', "name" => "formVictims",
                    'method' => 'post', "role" => "form", "class" => "form-horizontal")) }}
        <div id="formInvitar" class="row">
            <br/>
            <div class="form-group has-feedback">
                <label class="control-label col-xs-5" for="search">
                    @if($filtrado)
                    <a href="" onclick="formVictims.submit();" class="text-black h6">Mostrar todos</a>
                    @endif
                </label>
              <div class="col-xs-7">
                <input type="text" class="form-control input-sm" id="search3" name="search">
                <span class="glyphicon glyphicon-search form-control-feedback" onclick="formVictims.submit();"></span>
              </div>
            </div>
            
            <div class="panel-amigos col-xs-12 text-white">
                @foreach($user_friends as $key => $friend)
                <div class="col-xs-11 col-xs-offset-1 item-amigos">
                    <ul class="list-inline lista-amigos">
                      <li style="margin-top: 11px;">{{ Form::checkbox("victims", $friend->id, false) }}</li>
                      <li><img src="{{ $friend->picture->data->url }}" class="img-rounded" width="36"/>&nbsp;&nbsp; </li>
                      <li style="max-width: 235px;font-size:1.2em;">{{ $friend->name }}</li>
                    </ul>     
                </div>
                @endforeach
            </div>
            
            <div>
                <p>
                    <span class="text-white small">NO TE PREOCUPES QUE PUEDES REGRESAR A ACUMULAR MÁS </span><b><span class="text-black small">VÍCTIMAS</span></b>
                </p>
            </div>
        </div>
    {{ Form::close() }}

    <div class="text-center">
        <br/>
        <a class="boton-small sendRequest" href="">
            Listo!
        </a> 
    </div>

    <div class="text-center">
        <br/><br/><br/>
        <a class="boton" href="{{route('categorias')}}">
            Cambiar de categoría
        </a>
    </div>

    
<script type="text/javascript">

    jQuery(document).ready(function()
    {
                    jQuery(".sendRequest").bind("click",function(e)
                    {
                            e.preventDefault();
                            console.log("clic...");
                            iniciar();

                    });

                    iniciar = function()
                    {
                            FB.getLoginStatus(function (response) 
                            {				
                                            IsFacebookConnected();				
                            });
                    }

                    IsFacebookConnected = function()
                    {
                            FB.getLoginStatus(function (response) 
                            {		    
                                    if (response.authResponse) {
                                        console.log(response);
                                        sendRequest(response.authResponse);
                                    }
                            });
                    }

//                    login = function()
//                    {
//                            FB.login(function (response)
//                            {
//                                
//                                    if (response.authResponse)
//                                    {
//                                        sendRequest();
//                                    }
//                            });
//                    }
                                    

        sendRequest = function(authResponse) {
           // Get the list of selected friends
            var sendUIDs = '';
            var contador = 0;
            var mfsForm = document.getElementById('formVictims');
            console.log(mfsForm.victims);
            if(mfsForm.victims.length > 0) {
                for(var i = 0; i < mfsForm.victims.length; i++) {
                    if(mfsForm.victims[i].checked) {
                        sendUIDs += mfsForm.victims[i].value + ',';
                        contador++;
                    }
                }
            } else {
                if ($( "form input:checkbox" ).length > 0)
                    if ($( "form input:checkbox" )[0].checked) {
                        sendUIDs = $( "form input:checkbox" )[0].value;
                     contador++;
                    }
            }
             console.log(sendUIDs);
             if (sendUIDs === '') {
                 return;
             }
             if (contador > 3) {
		alert("Sólo puede seleccionar 3 amigos.");
                 return;
             }
           // Use FB.ui to send the Request(s)
            FB.ui({method: 'apprequests',
                to: sendUIDs,
                title: 'Enviar esta solicitud de tus victimas',
                message: 'Quiero que seas mi víctima.',
//                data: 'friend=yes&id=' + authResponse.userID,
                data: '{"idfrom":'+authResponse.userID+',"friend":"yes"}',
//                action_type:'send',
//                object_id: '1490378904537262'  // i.e. '191181717736427' 
                redirect_uri: 'https://www.addicted-cyzone.com/html'//no se usa en el api js
                }, function (response) {
                    if (response && !response.error_code) {
                        console.log(response);
                        //alert('Posting completed.');
                        $.each(response.to, function( index, value ) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'ids[]',
                                value: value
                            }).appendTo(formVictims);
                        });
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'id_notification',
                            value: response.request
                        }).appendTo(formVictims);
			formVictims.action = "{{ URL::route('victim.savevictims', $idCate) }}";                        
                        formVictims.submit();
                    } else {
                      //alert('Error while posting.');
                    }
                }
            );
        }
    });

</script>

@stop    
