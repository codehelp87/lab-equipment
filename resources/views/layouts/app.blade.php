<!DOCTYPE html>
<html>
    <head>
        <title>Scientist A medical Category Flat Bootstrap Responsive Website Template | Home :: w3layouts</title>
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <!-- Custom Theme files -->
        <!--theme-style-->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!--//theme-style-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="Scientist Responsive web template" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </head>
<body>
    <div id="app">
      <!--header-->
        <div class="header header-top">
            <div class="container">
                <div class="logo">
                    <h1><a href="{{ url('/login') }}">
                        Scientist
                    </a></h1>
                </div>
                <div class="top-nav">
                    <span class="menu"><img src="{{ asset('images/menu.png') }}" alt=""> </span>
                    <ul>
                        <li class="active"><a href="{{ url('/') }}">Home</a></li>
                        @if (Route::has('login'))
                        
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                        
                        @endif
                    </ul>
                    <div class="clearfix"> </div>
                    <!--script-->
                    <script>
                    $("span.menu").click(function(){
                        $(".top-nav ul").slideToggle(500, function() {

                        });
                    });
                    </script>
                </div>
                <div class="clearfix"> </div>
            </div>
            <!---->
        </div>
        @yield('content')
        <!--address-->
            <div class="address">
                <div class="container">
                    <div class=" address-more">
                        <h3>Address</h3>
                        <div class="col-md-4 address-grid">
                            <i class="glyphicon glyphicon-map-marker"></i>
                            <div class="address1">
                                <p>Lorem ipsum dolor</p>
                                <p>TL 19034-88974</p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="col-md-4 address-grid ">
                            <i class="glyphicon glyphicon-phone"></i>
                            <div class="address1">
                                <p>+885699655</p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="col-md-4 address-grid ">
                            <i class="glyphicon glyphicon-envelope"></i>
                            <div class="address1">
                                <p><a href="mailto:@example.com"> @example.com</a></p>
                            </div>
                            <div class="clearfix"> </div>
                        </div>
                        <div class="clearfix"> </div>
                    </div>
                </div>
            </div>
            <!--//address-->
    </div>
 <!--footer-->
        <div class="footer">
            <div class="container">
                <div class="col-md-4 footer-top">
                    <h3><a href="/login">scientist</a></h3>
                </div>
                <div class="col-md-4 footer-top1">
                    <ul class="social">
                        <li><a href="#"><i> </i></a></li>
                        <li><a href="#"><i class="dribble"> </i></a></li>
                        <li><a href="#"><i class="facebook"> </i></a></li>
                    </ul>
                </div>
                <div class="col-md-4 footer-top2">
                    <p >© 2016 Scientist. All rights reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
</html>
