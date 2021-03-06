<div class="modal fade" id="confirm_modal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="confirm_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="zmdi zmdi-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<p id="confirm_msg"></p>
				<input type="hidden" id="confirm_id" name="confirm_id">
				<input type="hidden" id="confirm_type" name="confirm_type">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-danger pull-left" data-dismiss="modal">No</button>
				<button type="button" class="btn btn-sm btn-info btn-permission" id="btn_confirm">Yes</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="msg_modal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="msg_title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="zmdi zmdi-close"></span>
				</button>
			</div>
			<div class="modal-body">
				<p id="msg_content"></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-success" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>