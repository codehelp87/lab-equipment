@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h5 class="text-left">Confirmaion email:</h5>
			<p class="text-left">
				Dear {{ $name }} ,<br><br>
				Congratulations!
You have completed the traing session and you can now use the following equipment..<br><br>
				Equipment: {{ $equipment }}<br><br>
				Please <a href="/users/{{ base64_encode($email) }}/activate">click here</a> to update your account informaion.
				Thanks,<br><br>
				The Equipment Administrator
			</p>
		</div>
		
	</div>
</div>
@endsection