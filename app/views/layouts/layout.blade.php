<!DOCTYPE html>
<html lang="en" xmlns:fb="http://ogp.me/ns/fb#">    
  <head>
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cyzone - Víctima de tu adicción">
    <meta name="author" content="">
    
    <title>Cyzone - Víctima de tu adicción</title>
    
    <link rel="shortcut icon"  href="favicon.ico"><!-- Major Browsers -->
    <!--[if IE]><link rel="SHORTCUT ICON" href="favicon.ico"/><![endif]--><!-- Internet Explorer-->
    
    {{ HTML::style('bower_components/normalize.css/normalize.css'); }}
    
    {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.min.css'); }}
    {{ HTML::style('bower_components/bootstrap/dist/css/bootstrap.css.map'); }}

    {{ HTML::style('bower_components/bootstrap-datepicker/css/datepicker.css'); }}

    
    {{ HTML::style('bower_components/font-awesome/css/font-awesome.min.css'); }}
    
    {{ HTML::style('css/main.css'); }}
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
    	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.2.0/respond.js"></script>
    <![endif]-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>

  <body>
    <div id="fb-root"></div>
<script type="text/javascript">
    var url_face_page = "https://www.facebook.com/pages/Cyzone-Tester/129158347286143?sk=timeline"; 
    var url_face_tab_app = "https://www.facebook.com/pages/Cyzone-Tester/129158347286143?v=app_102227703153175"; 
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

    {{ HTML::script('bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js'); }}
    {{ HTML::script('bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js'); }}
    
  </body>
</html>
