<form class="form-horizontal user-account" id="<?php echo e($user->id); ?>">
	<div class="form-group">
		<label for="student_id" class="col-sm-2 control-label">Student ID</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="student_id" name="student_id" placeholder="Student ID" value="<?php echo e($user->student_id); ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-10">
			<input type="email" class="form-control" id="name" name="name" placeholder="Name" value="<?php echo e($user->name); ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo e($user->email); ?>" readonly="readonly">
		</div>
	</div>
	<div class="form-group">
		<label for="phone" class="col-sm-2 control-label">Phone</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="<?php echo e($user->phone); ?>">
		</div>
	</div>
	<div class="form-group">
		<label for="office" class="col-sm-2 control-label">Office</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="office" name="office" placeholder="Office" value="<?php echo e($user->office_location); ?>">
		</div>
		<hr>
	</div>
	<hr>
	<div class="form-group">
		<label for="status" class="col-sm-2 control-label">Account Status</label>
		<div class="col-sm-6">
			<select name="status" id="status" class="form-control" required="required">
				<option value="">Status</option>
				<?php if($user->status == 1): ?>
				<option value="1" selected="selected">Active</option>
				<?php else: ?>
				<option value="1">Active</option>
				<?php endif; ?>
				<?php if($user->status == 0): ?>
				<option value="0" selected="selected">Inactive</option>
				<?php else: ?>
				<option value="0">Inactive</option>
				<?php endif; ?>
			</select>
		</div>
	</div>
	<hr>
	<div class="form-group">
		<label for="role" class="col-sm-2 control-label">Assign Role</label>
		<div class="col-sm-6">
			<select name="role" id="role" class="form-control" required="required">
				<option value="">Change Role</option>
				<?php if($user->role_id == 1): ?>
				<option value="1" selected="selected">Student</option>
				<?php else: ?>
				<option value="1">Student</option>
				<?php endif; ?>
				<?php if($user->role_id == 2): ?>
				<option value="2" selected="selected">Admin</option>
				<?php else: ?>
				<option value="2">Admin</option>
				<?php endif; ?>
			</select>
		</div>
	</div>
	<hr>
	<?php if(!is_null($equipments)): ?>
	<?php $id = '';?>
	<h6>Status by equipment</h6>
	<?php $__currentLoopData = $equipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $equipment): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
	<?php $id .= $equipment->id.'##'; ?>
	<?php if(in_array($equipment->id, $trainedEquipments)): ?>
	<div class="form-group">
		<label for="equipment[]" class="col-sm-2 control-label"> <?php echo e($equipment->title); ?></label>
		<div class="col-sm-6">
			<select name="equipment[]" id="equipment[]" class="form-control" required="required">
				<option value="">Status</option>
				<?php if($equipment->availability == 1): ?>
				<option value="1" selected="selected">Active</option>
				<?php else: ?>
				<option value="1">Active</option>
				<?php endif; ?>
				<?php if($equipment->availability == 0): ?>
				<option value="0" selected="selected">Inactive</option>
				<?php else: ?>
				<option value="0">Inactive</option>
				<?php endif; ?>
			</select>
		</div>
	</div>
	<?php else: ?>
	<div class="form-group">
		<label for="equipment[]" class="col-sm-2 control-label"> <?php echo e($equipment->title); ?></label>
		<div class="col-sm-6">
			<select name="equipment[]" id="equipment[]" class="form-control" required="required">
				<option value="">Status</option>
				<option value="1">Active</option>
				<option value="0" selected="selected">Inactive</option>
			</select>
		</div>
	</div>
	<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
	<?php endif; ?>
	<input type="hidden" name="equipment_id" id="equipment_id" class="form-control" value="<?php echo e($id); ?>">
</form>