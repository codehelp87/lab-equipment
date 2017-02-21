<form class="form-horizontal" id="manage_lab">
    <input type="hidden" name="_token" id="_token" class="form-control" value="<?php echo e(csrf_token()); ?>">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Lab Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="Lab Name">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-lab">Save</button>
        </div>
    </div>
</form>

<div class="col-sm-8">
<div class="table-responsive">
    <table class="table table-responsive" id="list-labs">
        <tbody>
            <?php if($labs->count() > 0): ?>
            <?php $__currentLoopData = $labs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lab): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
            <tr id="edit-lab<?php echo e($lab->id); ?>">
                <td>
                   <?php echo e($lab->title); ?><br>
                </td>
                <td><a href="#" class="edit-lab" id="<?php echo e($lab->id); ?>" title="<?php echo e($lab->title); ?>">Edit</a></td>
                <td><a href="#"  class="delete-lab" id="<?php echo e($lab->id); ?>" rel= "<?php echo e(route('delete_equipment', ['id' => $lab->id ])); ?>">Delete</a></td>
            </tr>
            <tr>
                <td colspan="8">
                    <div class="display<?php echo e($lab->id); ?>" id="edit-eqipment<?php echo e($lab->id); ?>" style="display: none;">dddjdjdjdjjddjdjdddjjdjjddjddjjddj</div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
