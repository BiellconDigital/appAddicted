@extends('layouts/layout')

@section('content')
    @if(Session::has('message'))
            <div class="alert alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{ Session::get('message')}}
            </div>
    @endif
    
    <img src="{{asset('img/logo-thums.png')}}" />

    {{ Form::open(array('route' => array('victim.savevictims', $idCate), 'id' => 'formVictims', "name" => "formVictims",
                    'method' => 'post', "role" => "form", "class" => "form-horizontal")) }}
        <div id="formInvitar" class="row">
                <div class="form-group has-feedback">
                  <label class="control-label col-xs-5" for="inputSuccess3">LISTA DE AMIGOS</label>
                  <div class="col-xs-7">
                    <input type="text" class="form-control input-sm" id="inputSuccess3">
                    <span class="glyphicon glyphicon-search form-control-feedback"></span>
                  </div>
                </div>
            <div class="panel-amigos col-xs-12">
                @foreach($user_friends as $key => $friend)
                <div class="col-xs-6 item-amigos">
                    <ul class="list-inline lista-amigos">
                      <li>{{ Form::checkbox("victims", $friend->id, false) }}</li>
                      <li><img src="{{ $friend->picture->data->url }}" class="img-rounded" width="29"/>&nbsp;&nbsp; </li>
                      <li style="max-width: 85px;">{{ $friend->name }}</li>
                    </ul>     
                </div>
                @endforeach
            </div>
        </div>
    {{ Form::close() }}

    <div class="text-center">
        <br/>
        <a class="boton sendRequest" href="">
            Invitar <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="20" /></i>
        </a> 
    </div>

    <div class="">
        <br/><br/><br/><br/>
        <a class="boton-small" href="{{route('categorias')}}">
            Categorias <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="20" /></i>
        </a> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <a class="boton-small" href="{{route('ranking')}}">
            Ranking <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="20" /></i>
        </a> 
    </div>

    
    <script type="text/javascript">

            jQuery(document).ready(function()
            {
                    console.log("entrado...");
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
                                    sendRequest();			
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
                                    

        sendRequest = function() {
           // Get the list of selected friends
           var sendUIDs = '';
           var mfsForm = document.getElementById('formVictims');
             for(var i = 0; i < mfsForm.victims.length; i++) {
               if(mfsForm.victims[i].checked) {
                 sendUIDs += mfsForm.victims[i].value + ',';
               }
             }

           // Use FB.ui to send the Request(s)
            FB.ui({method: 'apprequests',
                to: sendUIDs,
                title: 'Enviar esta solicitud de tus victimas',
                message: 'Quiero que seas mi víctima.'
//                action_type:'send',
//                object_id: '1490378904537262'  // i.e. '191181717736427' 
//                redirect_uri: 'https://www.addicted-cyzone.com/index.php/victimas/votar'//no se usa en el api js
                }, function (response) {
                    if (response && !response.error_code) {
//                        console.log(response);
                        //alert('Posting completed.');
                        $.each(response.to, function( index, value ) {
                            $('<input>').attr({
                                type: 'hidden',
                                name: 'ids[]',
                                value: value
                            }).appendTo(formVictims);
                        });                        
                        formVictims.submit();
                    } else {
                      //alert('Error while posting.');
                    }
                }
            );
        }


//                    login = function()
//                    {
//                            FB.login(function (response)
//                            {
//                                    if (response.authResponse)
//                                    {
//                                             FB.api('/me', function(response)
//                                             {
//						console.log('redirigiendo callback....');
//                                                    window.location = "https://www.addicted-cyzone.com/index.php/login/fb/callback";
//                                             });
//                                    } else {
//				    	console.log('User cancelled login or did not fully authorize.');
//				    }
//
//                            }, { scope: 'email, user_friends' });
//                    }
            });

/*
    FB.api(
      'me/objects/cyzone_addicted:participar',
      'post',
      {
        app_id: 1483842561857563,
        type: "cyzone_addicted:participar",
        url: "http://samples.ogp.me/1490378904537262",
        title: "Sample Participar",
        image: "https://fbstatic-a.akamaihd.net/images/devsite/attachment_blank.png",
        description: ""
      },
      function(response) {
        // handle the response
      }
    );
        
 FB.ui({method: 'apprequests',
  message: 'Take this bomb to blast your way to victory!',
  to: {user-ids}, 
  action_type:'send',
  object_id: 'YOUR_OBJECT_ID'  // i.e. '191181717736427' 
}, function(response){
    console.log(response);
}); 
 */
    </script>

@stop    