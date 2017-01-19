<div class="modal fade manage-user-account" id="manage-user-account{{ $user->id }}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit User | {{ $user->name }}</h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default no" data-dismiss="modal" id="{{ $user->id }}">No</button>
				<button type="button" class="btn btn-default ok" id="{{ $user->id }}">Ok</button>
			</div>
		</div>
	</div>
</div>