<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Training Request:</h5>
			<p class="text-left">
				Dear Admin,<br><br>
				<?php echo e($studentName); ?> has signed up for the basic equipment training session.<br><br>
				<?php $newDate = date('F d Y'); ?>
				<span>Date: <?php echo e($newDate); ?> </span><br><br>
				Name: <?php echo e($equipmentName); ?> <br><br>
				Please check training request on the admin dashboard.<br><br>
				Thanks.<br><br>
			</p>
		</div>
		
	</div>
</div>