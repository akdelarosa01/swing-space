<div class="modal fade" id="user_master_modal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<span>User Access</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="zmdi zmdi-close"></span>
				</button>
			</div>
			<form action="../../admin/user-master/assign-access" method="post" class="form-horizontal" id="frm_access">
				@csrf
                <input type="hidden" id="user_id" name="user_id">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tbl_modules" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Page</th>
                                    <th>Read / Write</th>
                                    <th>Read</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_modules_body"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info btn-sm">Save</button>
                    <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">Cancel</button>
                </div>
            </form>
		</div>
	</div>
</div>