<div class="modal fade" id="receive_items_modal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<span class="trn">Receive Item</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="zmdi zmdi-close"></span>
				</button>
			</div>
			<form action="../../receive-items/save" method="post" class="form-horizontal" id="frm_items">
				@csrf
                <input type="hidden" class="clear" id="item_id" name="item_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="item_name" class="control-label text-right col-md-3 trn">Item Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear" id="item_name" name="item_name">
                                    <div id="item_name_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="item_type" class="control-label text-right col-md-3 trn">Item Type</label>
                                <div class="col-md-8">
                                    <select name="item_type" id="item_type" class="form-control form-control-sm clear"></select>
                                    <div id="item_type_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="quantity" class="control-label text-right col-md-3 trn">Quantity</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control form-control-sm clear" id="quantity" name="quantity" maxlength="5">
                                    <div id="quantity_feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="minimum_stock" class="control-label text-right col-md-3 trn">Minimum Stock</label>
                                <div class="col-md-8">
                                    <input type="number" class="form-control form-control-sm clear" id="minimum_stock" name="minimum_stock" maxlength="5">
                                    <div id="minimum_stock_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="uom" class="control-label text-right col-md-3 trn">Unit of Measurement</label>
                                <div class="col-md-8">
                                    <select name="uom" id="uom" class="form-control form-control-sm clear"></select>
                                    <div id="uom_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarks" class="control-label text-right col-md-3 trn">Remarks</label>
                                <div class="col-md-8">
                                    <textarea class="form-control form-control-sm clear" id="remarks" name="remarks"></textarea>
                                    <div id="remarks_feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered" id="tbl_recitems" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <input type="checkbox" class="check_all_items">
                                            </th>
                                            <th width="15%" class="trn">Item Name</th>
                                            <th width="15%" class="trn">Item Type</th>
                                            <th width="15%" class="trn">Quantity</th>
                                            <th width="15%" class="trn">Minimum Stock</th>
                                            <th width="10%" class="trn">UoM</th>
                                            <th width="20%" class="trn">Remarks</th>
                                            <th width="10%" class="trn"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_recitems_body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}

                    
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info btn-sm btn-permission">
                        <span class="trn">Save</span>
                    </button>
                    {{-- <button type="button" class="btn btn-danger btn-sm btn-permission">
                        <span class="trn">Delete</span>
                    </button> --}}
                </div>
            </form>
		</div>
	</div>
</div>