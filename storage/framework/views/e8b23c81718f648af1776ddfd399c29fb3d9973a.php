<p style="margin-top: 70px;">
	<h4 class="student"> Hello, <?php echo e(Auth::user()->name); ?>! <form action="/logout" method="post">
		<button type="submit" class=" btn btn-default pull-right" style="margin-top: -20px;">Logout</button>
		<input type="hidden" name="_token" id="_token" class="form-control" value="<?php echo e(csrf_token()); ?>">
	</form>
	</h4>
	
</p>