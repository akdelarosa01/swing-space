<div class="modal fade" id="export_modal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<span>Product List</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="zmdi zmdi-close"></span>
				</button>
			</div>
			<form action="../../product-files" method="get" class="form-horizontal" id="frm_inventory">
				@csrf
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="input-group input-group-sm col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Product Type</span>
                            </div>
                            <select class="form-control form-control-sm" id="prod_type_export" name="prod_type"></select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="input-group input-group-sm col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text">File Type</span>
                            </div>
                            <select class="form-control form-control-sm" id="file_type" name="file_type">
                                <option value=""></option>
                                <option value="Excel">Excel</option>
                                <option value="PDF">PDF</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info btn-sm">Export</button>
                    <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">Cancel</button>
                </div>
            </form>
		</div>
	</div>
</div>