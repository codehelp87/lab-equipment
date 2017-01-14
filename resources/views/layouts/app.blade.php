<!DOCTYPE html>
<html>
    <head>
        <title>Home :: Lab Equipment</title>
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
                    <div class="clearfix"> </div>
                    <!--script-->
                    <script>
                    function toggleIcon(e) {
                        $(e.target)
                          .prev('.panel-heading')
                          .find(".more-less")
                          .toggleClass('glyphicon-plus glyphicon-minus');
                      }
                      $('.panel-group').on('hidden.bs.collapse', toggleIcon);
                      $('.panel-group').on('shown.bs.collapse', toggleIcon);
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