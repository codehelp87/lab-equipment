<!DOCTYPE html>
<html>
    <head>
        <title>Home :: Lab Equipment</title>
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <!--//theme-style-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
         <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
         <script type="text/javascript" src="{{ asset('lib/es6-shim/es6-shim.min.js')}}"></script>
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
            <div class="container">
                <div class="row">
                 <hr style="border: 1px solid #f8f8f8;">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="text-center" style="padding: 20px;">Copyright UNIST, Department of Chemistry &copy <?php echo date('Y'); ?> all rights reserved</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Scripts -->
        <!-- Latest compiled and minified JavaScript -->
        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/moment.js')}}"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.simplePagination.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/bootbox.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.table2excel.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/keep_alive.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/user.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lab.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/add_equipment.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/book_equipment.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/training_request.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lab_usage.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/notification.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                var table = $('#notifications, .equipment-book, #list-equipment, #list-labs, .user-account-list, #list-notification, #notifications, #booking-history');
                table.simplePagination({
                    perPage: 10,
                    previousButtonClass: "btn btn-default",
                    nextButtonClass: "btn btn-default"
                });
            });
        </script>
        @include('student.cancel_booking_modal')
        @include('student.contact_the_admin_modal')
    </body>
</html>