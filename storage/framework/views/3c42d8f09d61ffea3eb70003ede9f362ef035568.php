<form class="form-horizontal edit_notification" id="<?php echo e($notification->id); ?>">
<h5 style="padding-left: 20px;">Edit | <?php echo e($notification->title); ?> </h5>
    <div class="form-group">
        <label for="title" class="col-sm-2 control-label">Title</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="title" id="title" placeholder="Title" required="required" value="<?php echo e($notification->title); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="content" class="col-sm-2 control-label">Content</label>
        <div class="col-sm-10">
            <textarea name="content" id="content" class="form-control" rows="3" required="required" required="required"><?php echo e($notification->content); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default" id="edit-notification">Update</button>
            <button type="submit" class="btn btn-large btn-default close-notification" id="<?php echo e($notification->id); ?>">Cancel</button>
            <a href="#"  class="delete-notification" id="<?php echo e($notification->id); ?>" rel= "<?php echo e(route('delete_notification', ['id' => $notification->id ])); ?>">Delete</a>
        </div>
    </div>
</form>