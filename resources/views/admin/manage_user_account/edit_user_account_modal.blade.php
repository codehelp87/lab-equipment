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
							<input type="email" class="form-control" id="phone" placeholder="Phone" value="{{ Auth::user()->phone }}">
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
						<select name="status" id="status" class="form-control" required="required">
							<option value="1">Active</option>
						</select>
					</div>
					<hr>
					<div class="col-sm-4">
						<label for="office" class="col-sm-2 control-label">Assign Role</label>
						<select name="role" id="status" class="form-control" required="required">
							<option value="1">Change Role</option>
						</select>
					</div>
					<hr>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-large btn-default">Save</button>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-default">Ok</button>
			</div>
		</div>
	</div>
</div>