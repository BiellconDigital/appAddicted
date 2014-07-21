@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
        
        <br/><br/><br/><br/><br/><br/><br/>
        <p class="text-center">
            <img src="{{asset('img/logo-inicio.png')}}" />
        </p>
        <br/><br/><br/><br/><br/>
        <p class="text-center">
            <a class="boton ingresar" href=" ">Participa <i class=""><img src="{{asset('img/icono-enviar.png')}}" width="30" /></i></a>
        </p>
                    
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
                                                        window.location = "https://www.addicted-cyzone.com/index.php/nopermitdo";
                                                    } else {
                                                        console.log('redirigiendo callback....');
                                                        window.location = "https://www.addicted-cyzone.com/index.php/login/fb/callback";
                                                    }
                                                } else {
                                                    console.log('no se autorizo...');
                                                }
                                             });
                                             
                                    } else {
				    	console.log('User cancelled login or did not fully authorize.');
				    }

                            }, { scope: 'email, user_friends' });
                    }
            });
        </script>


@stop
