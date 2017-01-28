<div class="modal fade manage-user-account" id="manage-user-account">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit User's information</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<div class="form-group">
					<div class="col-sm-6">
						<a class="btn btn-link text-center" data-email="{{ $user->email }}" id="send-reset-password-link" href="#" rel="/password/email">
							Reset Password(send a link to reset password)
						</a>
					</div>
				</div>
				<button type="button" class="btn btn-default no" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-default ok">Ok</button>
			</div>
		</div>
	</div>
</div>