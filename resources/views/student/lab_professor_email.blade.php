@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Training Request:</h5>
			<p class="text-left">
				Dear Admin,<br><br>
				{{ $studentName }} has signed up for the basic equipment training session.<br><br>
				<?php $newDate = date('F d Y'); ?>
				Date: {{ $newDate }} </span> <br><br>
				Name: <span>{{ $equipmentName }}</span> <br><br>
				Please check training request on the admin dashboard.<br><br>
				Thanks.<br><br>
			</p>
		</div>
		
	</div>
</div>
@endsection