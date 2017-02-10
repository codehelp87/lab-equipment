<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h5><a href="/home"> << Home </a></h5>
            <hr>
            <h5>My Notifications</h5>
             <?php if(Auth::user()->notifications->count() > 0): ?>
              <div class="table-responsive">
            <table class="table table-hover notifications">
                <tbody>
                    <?php $__currentLoopData = Auth::user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <tr>
                        <td><a href="#" class="read-notification" id="<?php echo e($notification->notification->id); ?>"><?php echo e($notification->notification->title); ?></a></td>
                        <td class="text-right"><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->notification->created_at)->format('Y/m/d')); ?></td>
                    </tr>
                    <tr id="view-content<?php echo e($notification->notification->id); ?>" style="display: none;">
                        <td colspan="2"><?php echo e($notification->notification->content); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                </tbody>
            </table>
            </div>
            <?php else: ?>
            <h4>Notifications not available for display</h4>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>