<form class="form-horizontal notification" id="notification">
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="title" id="title" placeholder="Title" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-2 control-label">Content</label>
        <div class="col-sm-10">
            <textarea name="content" id="content" class="form-control" rows="3" required="required" required="required"></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="save-notification">Publish now</button>
            <a class="btn btn-link admin-notification-list open" href="#">See lists</a>
        </div>
    </div>
</form>
<table class="table table-hover" id="list-notification">
    <tbody>
    <?php if($notifications->count() > 0): ?>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
            <tr id="edit-notification<?php echo e($notification->id); ?>">
                <td><?php echo e($notification->title); ?></td>
                <td ><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at)->format('Y/m/d')); ?></td>
                <td class="text-right"><a href="/notification/<?php echo e($notification->id); ?>/edit" class="edit-notification" id="<?php echo e($notification->id); ?>"> <i class="glyphicon glyphicon-pencil"></i> Edit</a>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <div class="display<?php echo e($notification->id); ?>" id="edit-notification<?php echo e($notification->id); ?>" style="display: none;"></div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
    <?php endif; ?>
    </tbody>
</table>