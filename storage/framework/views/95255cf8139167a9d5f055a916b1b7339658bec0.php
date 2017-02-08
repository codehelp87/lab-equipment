<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="text-center">Chemistry Dept. Equipment User System</h4>
                </div>
                <div class="panel-body">
                    <p class="text-center">
                        <small>Your Account has been de-activated<br> because it's been idle for 90 days.</small>
                    </p>
                    <h5 class="text-center">Please contact the adminstrator to re-activate your account. </h5>
                    <h5 class="text-center"><a href="#" class="open-modal">Contact the Administrator</a></h5>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>