<div class="col-sm-12">
<div class="table-responsive">
    <table class="table table-responsive" id="list-equipment">
        <tbody>
            <?php if($equipments->count() > 0): ?>
            <?php $__currentLoopData = $equipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
            <tr id="edit-eqipment<?php echo e($equipment->id); ?>">
                <td><?php echo e($equipment->model_no); ?></td>
                <td><img src="<?php echo e($equipment->equipment_photo); ?>" style="width: 50px; height: 50px;"></td>
                <td>
                    <Strong>Status</Strong><br>
                    <Strong>Unit Time</Strong><br>
                    <Strong>Max Time(per day)</Strong><br>
                </td>
                <td>
                    <?php echo e($equipment->availability == 1? 'Available': 'Unavailable'); ?><br>
                    <?php echo e($equipment->time_unit); ?> mins<br>
                    <?php echo e($equipment->max_reservation_time); ?> hours<br>
                </td>
                <td>
                    <Strong>Open</Strong><br>
                    <Strong>Cancel</Strong><br>
                </td>
                <td>
                    <span>30 minutes before</span><br>
                    <span>1 hour before</span><br>
                </td>
                <td><a href="#" class="edit-eqipment" id="<?php echo e($equipment->id); ?>" title="<?php echo e($equipment->title); ?>">Edit</a></td>
                <td><a href="#"  class="delete-equipment" id="<?php echo e($equipment->id); ?>" rel= "<?php echo e(route('delete_equipment', ['id' => $equipment->id ])); ?>">Delete</a></td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="display<?php echo e($equipment->id); ?>" id="edit-eqipment<?php echo e($equipment->id); ?>" style="display: none;">dddjdjdjdjjddjdjdddjjdjjddjddjjddj</div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>