@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable alert-danger">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif

        @if(!Session::has('friend'))
            <br/><br/><br/><br/><br/><br/><br/>
            <p class="text-center">
                <img src="{{asset('img/logo-inicio.png')}}" />
                <br/><br/><br/>
                <img src="{{asset('img/cinta-inicio.png')}}" />
            </p>
            <br/><br/><br/><br/>
            <p class="text-center">
                <a class="boton ingresar" href="">Empieza aquí! <i class=""><img src="{{asset('img/icono-enviar.png')}}"/></i></a>
            </p>
        @endif
                    
        <script type="text/javascript">

            jQuery(document).ready(function()
            {
                    console.log("entrado...");
                    jQuery(".ingresar").bind("click",function(e)
                    {
                            e.preventDefault();
                            console.log("clic...");
                            iniciar();

                    });

                    iniciar = function()
                    {
                        console.log('iniciando..');
                        FB.getLoginStatus(function (response) 
                        {				
                                        IsFacebookConnected();				
                        });
                    }

                    IsFacebookConnected = function()
                    {
                            FB.getLoginStatus(function (response) 
                            {			
                                    login();			
                            });
                    }


                    login = function()
                    {
                            FB.login(function (response)
                            {
                                
                                    if (response.authResponse)
                                    {
                                             FB.api('/me', function(response)
                                             {
                                                 console.log(response);
                                                if (response && !response.error_code) {
                                                    if (response.gender === 'male') {
	@if(isset($app_data))
                                                        window.location = "https://www.addicted-cyzone.com/index.php/victimas/votar/" + response.id + "/" + "{{ $app_data }}";
	@else
                                                        window.location = "https://www.addicted-cyzone.com/index.php/victimas/votar/" + response.id + "/0";
	@endif

                                                    } else {
                                                        window.location = "{{ URL::route('login.callback') }}";
                                                    }
                                                } else {
                                                    console.log('no se autorizo...');
                                                }
                                             });
                                             
                                    } else {
				    	console.log('User cancelled login or did not fully authorize.');
				    }

                            }, { scope: 'email, user_friends, user_status, publish_stream' });
                    }
                @if(Session::has('friend'))
                    setTimeout(function() {
                        iniciar();
                    }, 3700);
                @endif
                    
            });
        </script>


@stop
