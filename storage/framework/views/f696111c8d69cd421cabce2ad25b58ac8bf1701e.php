<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <?php if(Auth::user()->role_id == 2): ?>
        <div class="col-md-10 col-md-offset-1">
            <?php echo $__env->make('admin.manage_user_account.logout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <h4>Admin</h4>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Basic Info
                        </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.basic_info.edit_basic_info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Training Requests
                        </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.training_requests.training_request', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Training Completion
                        </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.training_completion.complete_training', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Total usage by Lab
                        </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.lab_usage.total_lab', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFive">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Manage user accounts
                        </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.manage_user_account.edit_user_account', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingSix">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Manage Equipments
                        </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.manage_equipment.manage_equipment', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php echo $__env->make('admin.add_more_equipment.add_more_equipment', ['labs' => $labs,
                            'equipments' => $equipments], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Manage Lab
                        </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.manage_lab.manage_lab', ['users' => $users], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingEight">
                        <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                            <i class="more-less glyphicon glyphicon-plus"></i>
                            Notification
                        </a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseEight">
                        <div class="panel-body">
                            <?php echo $__env->make('admin.notification.add_new_notification', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- panel-group -->
        </div>
        <?php else: ?>
        <div class="col-md-10 col-md-offset-1">
            <?php echo $__env->make('admin.manage_user_account.logout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <br>
            <hr>
            <p>
                <h5><strong>Notifications</strong> </h5>
                <div class="table-responsive">
                    <table class="table table-hover table-responsive notifications" id="notifications">
                        <tbody>
                            <?php if(Auth::user()->notifications->count() > 0): ?>
                            <?php $__currentLoopData = Auth::user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                           
                            <tr>
                                <td><a href="#" class="read-notification" id="<?php echo e($notification->notification->id); ?>"><?php echo e($notification->notification->title); ?></a></td>
                                <td class="text-right"><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->notification->created_at)->format('Y/m/d')); ?></td>
                            </tr>
                            <tr id="view-content<?php echo e($notification->notification->id); ?>" style="display: none;">
                                <td colspan="2"><?php echo e($notification->notification->content); ?></td>
                            </tr>
                           
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </p>
            <p>
                <div class="table-responsive">
                    <table class="table table-hover table-responsive">
                        <tbody>
                            <tr>
                                <?php
                                   $labBooking = LabEquipment\Booking::FindUserLab(Auth::user()->id);
                                ?>
                                <td><strong><?php echo e(Auth::user()->name); ?></strong></td>
                                <td align="center"><strong>Lab: <?php echo e(@$labBooking->lab->title); ?></strong></td>
                                <td><a  class="pull-right" href="<?php echo e(route('my_profile')); ?>" title="<?php echo e(Auth::user()-> name); ?>"><strong>See my page</strong></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </p>
            <hr>
            <p>
                <?php echo $__env->make('student.partials.upcoming_booking', ['bookings' => $userBookings], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </p>
            <hr>
            <p>
                <h5><strong>Book an Equipment</strong></h5>
                <div class="table-responsive">
                    <table class="table table-responsive equipment-book" id="book-equipment">
                        <tbody>
                            <?php if($equipments->count() > 0): ?>
                            <?php $__currentLoopData = $equipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <?php if(in_array($equipment->id, $trainedEquipments)): ?>
                            <tr id="edit-eqipment<?php echo e($equipment->id); ?>">
                                <td><?php echo e($equipment->title); ?><br>
                                    <?php echo e($equipment->model_no); ?><br>
                                <?php echo e($equipment->maker); ?><br></td>
                                <td><img src="<?php echo e($equipment->equipment_photo); ?>" style="width: 50px; height: 50px;"></td>
                                <td>
                                    <Strong>Status</Strong><br>
                                    <Strong>Unit Time</Strong><br>
                                    <Strong>Max Time(per day)</Strong><br>
                                </td>
                                <td>
                                    <?php echo e($equipment->availability == 1? 'Available': 'Unavailable'); ?><br>
                                    <?php echo e($equipment->time_unit); ?> mins<br>
                                    <?php echo e($equipment->max_reservation_time); ?> hr(s)<br>
                                </td>
                                <td>
                                    <Strong>Open</Strong><br>
                                    <Strong>Cancel</Strong><br>
                                </td>
                                <td>
                                    <span>30 minutes before</span><br>
                                    <span>1 hour before</span><br>
                                </td>
                                <td><a href="/equipments/<?php echo e(base64_encode($equipment->id)); ?>/booking" class="btn btn-default pull-right">Book Now</a></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="3">
                                    <?php
                                    $bookings = LabEquipment\Booking::findTotalLabUsage($equipment->id, Auth::user()->id);
                                    $created = new \Carbon\Carbon(@$bookings[0]->created_at);
                                    $now = \Carbon\Carbon::now();
                                    $difference = $created->diff($now)->days;
                                    ?>
                                    <span>Your Lab usage for this month: <strong><?php echo e((float) ($bookings->count() * 10)); ?> mins</strong></span><br>
                                    <span>You have not used this Equipment for : <strong> <?php echo e($difference); ?> day(s)</strong></span><br>
                                    <span class="text-default"><strong><small>(Your account will expired after 90 days without usage)</small></strong></span><br>
                                </td>
                                <td colspan="1"></td>
                            </tr>
                            <?php else: ?>
                            <?php
                            $bookings = LabEquipment\Booking::findTotalLabUsage($equipment->id, Auth::user()->id);
                            $created = new \Carbon\Carbon($equipment->created_at);
                            $now = \Carbon\Carbon::now();
                            $difference = $created->diff($now)->days;
                            ?>
                            <tr id="edit-eqipment<?php echo e($equipment->id); ?>">
                                <td><?php echo e($equipment->title); ?><br>
                                    <?php echo e($equipment->model_no); ?><br>
                                <?php echo e($equipment->maker); ?><br></td>
                                <td><img src="<?php echo e($equipment->equipment_photo); ?>" style="width: 50px; height: 50px;"></td>
                                <td>
                                    <Strong>Status</Strong><br>
                                    <Strong>Unit Time</Strong><br>
                                    <Strong>Max Time(per day)</Strong><br>
                                </td>
                                <td>
                                    <?php echo e($equipment->availability == 1? 'Available': 'Unavailable'); ?><br>
                                    <?php echo e($equipment->time_unit); ?> mins<br>
                                    <?php echo e($equipment->max_reservation_time); ?> hr(s)<br>
                                </td>
                                <td>
                                    <Strong>Open</Strong><br>
                                    <Strong>Cancel</Strong><br>
                                </td>
                                <td>
                                    <span>30 minutes before</span><br>
                                    <span>1 hour before</span><br>
                                </td>
                                <td><a href="/equipments/<?php echo e($equipment->id); ?>/booking" class="btn btn-default pull-right inActiveBtn" disabled="disabled">Book Now</a><br>
                                <p class="pull-right"><br>
                                    <a href="#" class="pull-right open-modal">Contact the administrator</a>
                                </p>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="3">
                                <span>Your Lab usage for this month: <strong>0 mins</strong></span><br>
                                <span>You have not used this Equipment for : <strong>0 days</strong><br></span><br>
                                <span class="text-danger"><strong>Your have not used this equipment for 0 day(s)</strong></span><br>
                            </td>
                            <td colspan="1"></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </p>
    </div>
    <?php endif; ?>
</div>
</div>
<!-- container -->
<style type="text/css">
input[type="checkbox"] {
width: 20px;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>