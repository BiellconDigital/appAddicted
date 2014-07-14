@extends('layouts/layout')

@section('content')
	@if(Session::has('url'))
		<div class="alert alert-dismissable">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  {{ Session::get('url')}}
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
                                                    window.location = "https://www.addicted-cyzone.com/index.php/login/fb/callback";
                                             });
                                    }
                            }, { scope: 'read_stream, email, user_birthday, user_friends' });
                    }
            });
        </script>


@stop
