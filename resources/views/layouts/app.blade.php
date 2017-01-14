<!DOCTYPE html>
<html>
    <head>
        <title>Scientist A medical Category Flat Bootstrap Responsive Website Template | Home :: w3layouts</title>
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <!-- Custom Theme files -->
        <!--theme-style-->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
        <!--//theme-style-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Scientist Responsive web template" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </head>
    <body>
        <div id="app">
            <!--header-->
            <div class="container">
                <div class="top-nav">
                    <ul>
                        @if (Route::has('login'))
                        
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                        
                        @endif
                    </ul>
                    <div class="clearfix"> </div>
                    <!--script-->
                    <script>
                    $("span.menu").click(function() {
                    $(".top-nav ul").slideToggle(500, function() {
                    });
                    });
                    </script>
                </div>
                <div class="clearfix"> </div>
            </div>
            @yield('content')
        </div>
        <!-- Scripts -->
        <script src="/js/app.js"></script>
    </body>
</html>