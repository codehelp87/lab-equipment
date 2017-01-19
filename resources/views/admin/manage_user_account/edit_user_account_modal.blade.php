<div class="modal fade" id="manage-user-account">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit User's Information</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="student_id" class="col-sm-2 control-label">Student ID</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="student_id" placeholder="Student ID" value="{{ Auth::user()->student_id }}">
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input type="email" class="form-control" id="name" placeholder="Name" value="{{ Auth::user()->name }}">
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="email" placeholder="Email" value="{{ Auth::user()->email }}" readonly="readonly">
						</div>
					</div>
					<div class="form-group">
						<label for="phone" class="col-sm-2 control-label">Phone</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="phone" placeholder="Phone" value="{{ Auth::user()->phone }}">
						</div>
					</div>
					<div class="form-group">
						<label for="office" class="col-sm-2 control-label">Office</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="office" placeholder="Office">
						</div>
					</div>
					<hr>
					<div class="col-sm-4">
					<label for="office" class="col-sm-2 control-label">Account Status</label>
						<select name="status" id="status" class="form-control" required="required">
							<option value="">Status</option>
							<option value="1">Active</option>
                            <option value="0">Inactive</option>
						</select>
					</div>
					<hr>
					<div class="col-sm-4">
						<label for="role" class="col-sm-2 control-label">Assign Role</label>
						<select name="role" id="status" class="form-control" required="required">
							<option value="">Change Role</option>
							<option value="1">Student</option>
							<option value="2">Admin</option>
						</select>
					</div>
					<hr>
					<div class="col-sm-4">
						<label for="equipment" class="col-sm-2 control-label">Status by equipment</label>
						<select name="role" id="equipment" class="form-control" required="required">
							<option value="">Status</option>
							<option value="1">Active</option>
                            <option value="0">Inactive</option>
						</select>
					</div>
					<hr>
					<div class="col-sm-4">
						<a class="btn btn-link" href="{{ url('/password/reset') }}">
                            Reset Password(send a link to reset password)
                        </a>
					</div>
					<hr>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default no" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-default ok">Ok</button>
			</div>
		</div>
	</div>
</div>