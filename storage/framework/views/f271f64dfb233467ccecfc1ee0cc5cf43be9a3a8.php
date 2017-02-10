<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?php echo $__env->make('admin.manage_user_account.logout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <hr>
            <h5>My Page <a href="/home" class="pull-right"> << Home </a></h5>
            <div class="table-responsive">
                <table class="table table-hover table-responsive">
                    <tbody>
                        <tr>
                            <td>
                                <strong><?php echo e(Auth::user()->name); ?></strong><br>
                                <strong><?php echo e(Auth::user()->student_id ?? Auth::user()->student_id ?? 'NIL'); ?></strong><br>
                            </td>
                            <td>
                                <?php echo e(Auth::user()->email); ?> <br>
                                <?php echo e(Auth::user()->phone ?? Auth::user()->phone ?? 'NIL'); ?>

                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingOne">
                                            <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                <i class="more-less glyphicon glyphicon-plus"></i>
                                                Change Password
                                            </a>
                                            </h4>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="panel-body">
                                                <?php echo $__env->make('student.change_password', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p>
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive">
                            <tbody>
                                <tr>
                                    <td>
                                        <select name="book_equipment" id="book_equipment" class="form-control" required="required">
                                            <option value="">Select Equipment</option>
                                            <?php if($trainings->count() > 0): ?>
                                            <?php $__currentLoopData = $trainings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $training): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                            <option value="<?php echo e(base64_encode($training->equipment->id)); ?>"><?php echo e($training->equipment->model_no); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                                            <?php endif; ?>
                                        </select>
                                    </td>
                                    <td><button type="button" class="btn btn-default pull-right" id="book-equipment">Book Now</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </p>
                <hr>
                <p>
                    <?php echo $__env->make('student.partials.upcoming_booking', ['bookings' => $bookings], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </p>
                <hr>
                <p>
                    <h5><strong>Booking History</strong></h5><br>
                    <?php if($bookingHistories->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive">
                            <tbody>
                                <?php $__currentLoopData = $bookingHistories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                                <tr>
                                    <td><strong><?php echo e($booking->equipment->title); ?></strong></td>
                                    <td><?php echo e($booking->equipment->model_no); ?></td>
                                    <td><?php echo e(date_format(new \DateTime($booking->booking_date), 'Y/m/d')); ?></td>
                                    <td><?php echo e(implode(' , ', $booking->cancelled_time_slot)); ?></td>
                                    <td>
                                        <?php if($booking->time_slot == null && $booking->status == 2): ?>
                                        <button type="button" class="btn btn-default pull-right completed"> Completed</button>
                                        <?php endif; ?>
                                        <?php if($booking->time_slot == null && $booking->status == 0): ?>
                                        <button type="button" class="btn btn-default pull-right cancelled"> Cancelled</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <h5>No booking history found</h5>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>