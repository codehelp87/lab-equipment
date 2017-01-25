@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Confirmaion email:</h5>
			<p class="text-left">
				Dear {{ $name }} ,<br>
				You have signed up for the basic equipment training session.<br>
				<?php $newDate = date_create($date); ?>
				Date: {{ date_format($newDate,'F') }} <span>1st(Wed) at 9:00am</span> <br>
				Location: {{ $location }}<br>
				Please be on time.<br>
				Thanks,<br><br>
				The Equipment Administrator
			</p>
		</div>
		
	</div>
</div>
@endsection