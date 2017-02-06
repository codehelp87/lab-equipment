<form class="form-horizontal" id="manage_lab">
    <input type="hidden" name="_token" id="_token" class="form-control" value="<?php echo e(csrf_token()); ?>">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Lab Name</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="Title">
        </div>
    </div>
    <div class="form-group">
        <label for="model_no" class="col-sm-2 control-label">Lab Location</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="model_no" name="model_no" placeholder="Lab Location">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-lab">Save</button>
        </div>
    </div>
</form>
<hr>
<h6>Assign Professor to Lab</h6>
<hr>
<form class="form-horizontal" id="assign_user_to_lab">
    <input type="hidden" name="_token" id="_token" class="form-control" value="<?php echo e(csrf_token()); ?>">
    <div class="form-group">
        <label for="assign_user" class="col-sm-2 control-label">Assign User</label>
        <div class="col-sm-10">
            <select name="user" id="user" class="form-control" required="required">
                <option value="">Choose User</option>
                <?php if($users->count() > 0): ?>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="lab" class="col-sm-2 control-label">Choose Lab</label>
        <div class="col-sm-10">
            <select name="lab" id="lab" class="form-control" required="required">
                <option value="">Choose Lab</option>
                <?php if($labs->count() > 0): ?>
                <?php $__currentLoopData = $labs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lab): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($lab->id); ?>"><?php echo e($lab->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-lab-user">Save</button>
        </div>
    </div>
</form>