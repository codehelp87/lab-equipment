<form class="form-horizontal approve-request" id="approve-request">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Equipment</label>
        <div class="col-sm-4">
            <select name="equipment" id="equipment" class="form-control" required="required">
                <option value="">Select Equipment</option>
                <?php if($equipments->count() > 0): ?>
                <?php $__currentLoopData = $equipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <option value="<?php echo e($equipment->id); ?>"><?php echo e($equipment->model_no); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-12">
            <table class="table table-responsive" id="display-training-request">
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="form-group">
        <label for="year" class="col-sm-2 control-label">Date of Training session</label>
        <div class="col-sm-2">
            <select name="year" id="year" class="form-control" required="required">
                <option value="">Select Year</option>
                <?php 
                  for($y = 2017; $y <= 2017; $y++) {
                    echo '<option value='.$y.'>'.$y.'</option>';
                  }
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select name="month" id="month" class="form-control" required="required">
                <option value="">Select Month</option>
                <?php 
                  for($m = 1; $m <= 12; $m++) {
                    echo '<option value='.$m.'>'.$m.'</option>';
                  }
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <select name="day" id="day" class="form-control" required="required">
                <option value="">Select Day</option>
                <?php 
                  for($d = 1; $d <= 31; $d++) {
                    echo '<option value='.$d.'>'.$d.'</option>';
                  }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="location" class="col-sm-2 control-label">Location</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="location" placeholder="Location">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-large btn-default">Send a confirmation email</button>
        </div>
    </div>
</form>
<?php echo $__env->make('admin.training_requests.training_request_modal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>