<form class="form-horizontal" id="edit-user-account">
    <div class="form-group">
        <div class="col-sm-4">
            <select name="lab" id="lab" class="form-control" required="required">
                <option value="0">See by Lab</option>
                <?php if($labs->count() > 0): ?>
                <?php $__currentLoopData = $labs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lab): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($lab->id); ?>"><?php echo e($lab->title); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-sm-4">
            <select name="status" id="status" class="form-control" required="required">
                <option value="">See by Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-responsive user-account-list">
                <tbody>
                    <?php if($users->count() > 0): ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                    <tr id="student-edit<?php echo e($user->id); ?>" data-index="<?php echo e($index + 1); ?>">
                        <td><?php echo e($loop->index + 1); ?></td>
                        <td><?php echo e($user->student_id); ?></td>
                        <td><?php echo e($user->name); ?></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e($user->phone); ?></td>
                        <td>
                            <?php if($user->status == 1): ?>
                            <?php echo e('Active'); ?>

                            <?php else: ?>
                            <?php echo e('Inactive'); ?>

                            <?php endif; ?>
                        </td>
                        <td><a href="#"  class="student-edit" id="<?php echo e($user->id); ?>">Edit</a></td>
                        <td><a href="#"  class="student-delete" id="<?php echo e($user->id); ?>" rel= "<?php echo e(route('delete_user', ['id' => $user->id])); ?>">Delete</a></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    <?php endif; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</form>
<?php echo $__env->make('admin.manage_user_account.edit_user_account_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>