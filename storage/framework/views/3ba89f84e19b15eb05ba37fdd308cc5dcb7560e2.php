<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Confirmaion email:</h5>
			<?php $newDate = date_create($date); ?>
			<p class="text-left">
				Dear <?php echo e($name); ?> ,<br><br>
				You have signed up for the basic equipment training session.<br><br>
				<span>Date: <?php echo e(date_format($newDate,'F')); ?> <?php echo e(date_format($newDate,'d')); ?>, <?php echo e(date_format($newDate,'Y')); ?>  <?php echo e($time); ?></span><br><br>
				Location: <?php echo e($location); ?><br><br>
				Please be on time.<br><br>
				Thanks,<br><br>
				The Equipment Administrator
			</p>

			<span class="text-center"><strong>Please contact the admin via email</strong></span> <br><br>
			<address>
			    <strong>Name:</strong> Diwesh Saxena <br>
				<strong>Email:</strong> diweshsaxena@gmail.com
			</address>
		</div>
		
	</div>
</div>