<form class="form-horizontal edit_equipment" id="<?php echo e($equipment->id); ?>" style="border-bottom: 1px solid #ccc;">
<h4 style="padding: 20px;">Edit | <?php echo e($equipment->title); ?> </h4>
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Title of Equipment</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="title" name="title" placeholder="Title of Equipment" value="<?php echo e($equipment->title); ?>" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="model" class="col-sm-2 control-label">Model No</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="model_no" name="model_no" placeholder="Model No" value="<?php echo e($equipment->model_no); ?>" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="maker" class="col-sm-2 control-label">Maker</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="maker" name="maker" placeholder="Maker" value="<?php echo e($equipment->maker); ?>" required="required">
        </div>
    </div>
    <div class="form-group">
        <label for="time_unit" class="col-sm-2 control-label">Unit Time</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="time_unit" name="time_unit" placeholder="10 Min" required="required" value="<?php echo e($equipment->time_unit); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="reservation_time" class="col-sm-2 control-label">Max Reservation Time</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="reservation_time" name="reservation_time" placeholder="3 hrs" required="required" value="<?php echo e($equipment->max_reservation_time); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="price_per_unit" class="col-sm-2 control-label">Price per unit Time</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="price_per_unit" name="price_per_unit" placeholder="KRW" required="required" value="<?php echo e($equipment->price_per_unit_time); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="availability" class="col-sm-2 control-label">Availability</label>
        <div class="col-sm-10">
            <select name="availability" id="availability" class="form-control" required="required">
                <option value="">Availability</option>
                <?php if($equipment->availability == 1): ?>
                    <option value="1" selected="selected">Available</option>
                <?php else: ?>
                    <option value="1">Available</option>
                <?php endif; ?>
                <?php if($equipment->availability == 0): ?>
                    <option value="0" selected="selected">Unavailable</option>
                <?php else: ?>
                    <option value="0">Unavailable</option>
                <?php endif; ?>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label for="photo" class="col-sm-2 control-label">Photo</label>
        <div class="col-sm-10">
            <input type="file" name="photo" id="photo" class="form-control">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default edit-equipment">Save</button>
        </div>
    </div>
</form>