<!DOCTYPE html>
<html>
    <head>
        <title>Home :: Lab Equipment</title>
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <!-- Custom Theme files -->
        <!--theme-style-->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
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
                </div>
                <div class="clearfix"> </div>
            </div>
            @yield('content')
        </div>
        <!-- Scripts -->
        <script src="{{ asset('jquery.v3.js') }}"></script>
        {{-- <script src="/js/jquery.min.js"></script> --}}
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="{{ asset('js/moment.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
        <script src="{{ asset('js/user.js') }}"></script>
        <script src="{{ asset('js/lab.js') }}"></script>
        <script src="{{ asset('js/add_equipment.js') }}"></script>
        <script src="{{ asset('js/book_equipment.js') }}"></script>
        <script src="{{ asset('js/training_request.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('#datetimepicker1').datepicker({
                    todayHighlight: true,
                    startDate: today,
                    format: "yyyy.mm.dd D",
                });
                $(document).find('span#time').text(today);
                $("#datetimepicker1").on("changeDate", function (e) {
                    //console.log(e.date);
                    $(document).find('span#time').text(e.date);
                });
            });
        </script>
    </body>
</html>