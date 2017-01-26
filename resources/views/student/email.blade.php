@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Confirmaion email:</h5>
			<p class="text-left">
				Dear {{ $name }} ,<br><br>
				You have signed up for the basic equipment training session.<br><br>
				<?php $newDate = date_create($date); ?>
				Date: {{ date_format($newDate,'F') }} <span>{{ date_format($newDate,'d') }}, {{ date_format($newDate,'Y') }} </span> <br><br>
				Location: {{ $location }}<br><br>
				Please be on time.<br><br>
				Thanks,<br><br>
				The Equipment Administrator
			</p>
		</div>
		
	</div>
</div>
@endsection