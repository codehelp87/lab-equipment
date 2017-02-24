<!DOCTYPE html>
<html>
    <head>
        <title>Home :: Lab Equipment</title>
        <link href="<?php echo e(asset('css/bootstrap.css')); ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo e(asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')); ?>">
        <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <!--//theme-style-->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
         <script type="text/javascript" src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
         <script type="text/javascript" src="<?php echo e(asset('lib/es6-shim/es6-shim.min.js')); ?>"></script>
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
            <?php echo $__env->yieldContent('content'); ?>
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
        <script type="text/javascript" src="<?php echo e(asset('js/moment.js')); ?>"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/bootbox.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/jquery.table2excel.min.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/keep_alive.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/user.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/lab.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/add_equipment.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/book_equipment.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/training_request.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/lab_usage.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/notification.js')); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset('js/jquery.simplePagination.js')); ?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $("table").simplePagination({
                    perPage: 10,
                    previousButtonClass: "btn btn-default",
                    nextButtonClass: "btn btn-default"
                });
            });
        </script>
        <?php echo $__env->make('student.cancel_booking_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('student.contact_the_admin_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </body>
</html>