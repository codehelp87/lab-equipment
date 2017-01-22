<p>
	<h4 class="student"> Hello, {{ Auth::user()->name }}! <form action="/logout" method="post">
		<button type="submit" class=" btn btn-default pull-right" style="margin-top: -20px;">Logout</button>
		<input type="hidden" name="_token" id="_token" class="form-control" value="{{ csrf_token() }}">
	</form>
	</h4>
	
</p>