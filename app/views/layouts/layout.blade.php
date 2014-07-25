<!DOCTYPE html>
<html lang="en">
  <head>
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Addicted Cyzone">
    <meta name="author" content="">
    
    <title>Addicted Cyzone</title>
    
    <link rel="shortcut icon"  href="favicon.ico"><!-- Major Browsers -->
    <!--[if IE]><link rel="SHORTCUT ICON" href="favicon.ico"/><![endif]--><!-- Internet Explorer-->
    
    {{ HTML::style('bower_components/normalize.css/normalize.css'); }}
    
    {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css'); }}
    {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.css.map'); }}

    {{ HTML::style('bower_components/font-awesome/css/font-awesome.min.css'); }}
    
    {{ HTML::style('css/main.css'); }}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>
    <![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  </head>

  <body>
    <div id="fb-root"></div>
<script type="text/javascript">
        window.fbAsyncInit = function () 
        {
            FB.init({
                appId: '102227703153175',
                status  : true,
                cookie: true,
                xfbml: true,
                version: 'v1.0',
                oauth : true
            });
            FB.Canvas.setAutoGrow(true);
            FB.Canvas.scrollTo(0,0);
        };
      (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

	
</script>
      
    <div class="container">
      <!-- Main component for a primary marketing message or call to action -->
      
      @yield('content')
      

    </div> <!-- /container -->
    {{ HTML::script('bower_components/bootstrap/dist/js/bootstrap.min.js'); }}

    
  </body>
</html>
