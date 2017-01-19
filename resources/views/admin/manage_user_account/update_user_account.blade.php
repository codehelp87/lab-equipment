<form class="form-horizontal user-account" id="user-account{{$user->id}}">
	<div class="form-group">
		<label for="student_id" class="col-sm-2 control-label">Student ID</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="student_id" placeholder="Student ID" value="{{ $user->student_id }}">
		</div>
	</div>
	<div class="form-group">
		<label for="name" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-10">
			<input type="email" class="form-control" id="name" placeholder="Name" value="{{ $user->name }}">
		</div>
	</div>
	<div class="form-group">
		<label for="email" class="col-sm-2 control-label">Email</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="email" placeholder="Email" value="{{ $user->email }}" readonly="readonly">
		</div>
	</div>
	<div class="form-group">
		<label for="phone" class="col-sm-2 control-label">Phone</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="phone" placeholder="Phone" value="{{ $user->phone }}">
		</div>
	</div>
	<div class="form-group">
		<label for="office" class="col-sm-2 control-label">Office</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="office" placeholder="Office" value="{{$user->office }}">
		</div>
		<hr>
	</div>
	<div class="form-group">
	<label for="status" class="col-sm-2 control-label">Account Status</label>
		<div class="col-sm-4">
			<select name="status" id="status" class="form-control" required="required">
				<option value="">Status</option>
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
		</div>
	</div>
	<hr>
	<div class="form-group">
	<label for="role" class="col-sm-2 control-label">Assign Role</label>
		<div class="col-sm-4">
			<select name="role" id="status" class="form-control" required="required">
				<option value="">Change Role</option>
				<option value="1">Student</option>
				<option value="2">Admin</option>
			</select>
		</div>
	</div>
	<hr>
	@if (!is_null($user->bookings))
	<h4>Status by equipment</h4>
	@foreach($user->bookings as $booking)
	<div class="col-sm-4">
		<label for="equipment" class="col-sm-2 control-label"> {{ $booking->title }}</label>
		<select name="equipment[]" id="equipment" class="form-control" required="required" name="equipment">
			<option value="">Status</option>
			<option value="1">Active</option>
			<option value="0">Inactive</option>
		</select>
	</div>
	@endforeach
	@endif
	<hr>
	<div class="col-sm-4">
		<a class="btn btn-link" href="{{ url('/password/reset') }}">
			Reset Password(send a link to reset password)
		</a>
	</div>
	<hr>
</form>