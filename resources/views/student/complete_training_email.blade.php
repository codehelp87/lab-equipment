<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Confirmaion email:</h5>
			<p class="text-left">
				Dear {{ $name }} ,<br><br>
				Congratulations!
You have completed the training session and you can now use the following equipment..<br><br>
				Equipment: {{ $equipment }}<br><br>
				Please <a href="<?php echo $_SERVER['HTTP_HOST'];?>/users/{{ base64_encode($email) }}/activate">click here</a> to update your account informaion.
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