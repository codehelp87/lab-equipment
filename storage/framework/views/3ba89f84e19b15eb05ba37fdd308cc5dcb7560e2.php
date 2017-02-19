<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Confirmaion email:</h5>
			<p class="text-left">
				Dear <?php echo e($name); ?> ,<br><br>
				You have signed up for the basic equipment training session.<br><br>
				<?php $newDate = date_create($date); ?>
				Date: <?php echo e(date_format($newDate,'F')); ?> <span><?php echo e(date_format($newDate,'d')); ?>, <?php echo e(date_format($newDate,'Y')); ?> </span> <br><br>
				Location: <?php echo e($location); ?><br><br>
				Please be on time.<br><br>
				Thanks,<br><br>
				The Equipment Administrator
			</p>
		</div>
		
	</div>
</div>