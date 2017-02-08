<!DOCTYPE html>
<html>
    <head>
        <title>Home :: Lab Equipment</title>
        <link href="<?php echo e(asset('css/bootstrap.css')); ?>" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo e(asset('bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')); ?>">
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
        <!-- Custom Theme files -->
        <!--theme-style-->
        <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" type="text/css" media="all" />
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
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <!-- Scripts -->
        <script src="/js/jquery.min.js"></script> 
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="<?php echo e(asset('js/moment.js')); ?>"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/js/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.1/css/bootstrap-datepicker.min.css" />
        <script src="<?php echo e(asset('js/bootbox.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/jquery.table2excel.min.js')); ?>"></script>
        <script src="<?php echo e(asset('js/keep_alive.js')); ?>"></script>
        <script src="<?php echo e(asset('js/user.js')); ?>"></script>
        <script src="<?php echo e(asset('js/lab.js')); ?>"></script>
        <script src="<?php echo e(asset('js/add_equipment.js')); ?>"></script>
        <script src="<?php echo e(asset('js/book_equipment.js')); ?>"></script>
        <script src="<?php echo e(asset('js/training_request.js')); ?>"></script>
        <script src="<?php echo e(asset('js/lab_usage.js')); ?>"></script>
        <script src="<?php echo e(asset('js/notification.js')); ?>"></script>
        <?php echo $__env->make('student.cancel_booking_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('student.contact_the_admin_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </body>
</html>