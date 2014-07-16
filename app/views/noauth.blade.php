@extends('layouts/layout')

@section('content')
	@if(Session::has('message'))
		<div class="alert alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('message')}}
		</div>
	@endif
        
        <p class="text-center">
            <a class="btn btn-lg btn-primary ingresar" href=" "><i class="icon-facebook"></i> Participa</a>
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
						console.log('redirigiendo callback....');
                                                    window.location = "https://www.addicted-cyzone.com/index.php/login/fb/callback";
                                             });
                                    } else {
				    	console.log('User cancelled login or did not fully authorize.');
				    }

                            }, { scope: 'email, user_friends' });
                    }
            });
        </script>


@stop
