<div class="modal fade" id="add_product_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Add New Product</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <form action="../../add-products/save" method="get" class="form-horizontal" id="frm_products">
                @csrf
                <input type="hidden" id="id" class="clear" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="prod_name" class="control-label text-right col-md-3 trn">Product Name</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control form-control-sm clear validate" id="prod_name" name="prod_name">
                                    <div id="prod_name_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prod_type" class="control-label text-right col-md-3 trn">Product Type</label>
                                <div class="col-md-9">
                                    <select class="form-control form-control-sm clear validate-select" id="prod_type" name="prod_type"></select>
                                    <div id="prod_type_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="variants" class="control-label text-right col-md-3 trn">Variants</label>
                                <div class="col-md-9">
                                    <select class="form-control form-control-sm clear validate-select" id="variants" name="variants"></select>
                                    <div id="variants_feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="price" class="control-label text-right col-md-3 trn">Price</label>
                                <div class="col-md-9">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">₱</span>
                                        </div>
                                        <input type="text" class="form-control form-control-sm clear validate" id="price" name="price">
                                        <div id="price_feedback"></div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="prod_type" class="control-label text-right col-md-3 trn">Description</label>
                                <div class="col-md-9">
                                    <textarea class="form-control form-control-sm clear" id="description" name="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm" style="width:100%;" id="tbl_products">
                                    <thead>
                                        <tr>
                                            <th width="5%">
                                                <input type="checkbox" class="check_all_products">
                                            </th>
                                            <th width="15%" class="trn">Product Code</th>
                                            <th width="15%" class="trn">Product Name</th>
                                            <th width="15%" class="trn">Product Type</th>
                                            <th width="15%" class="trn">Variants</th>
                                            <th width="10%" class="trn">Price</th>
                                            <th width="20%" class="trn">Description</th>
                                            <th width="10%" class="trn"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_products_body"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>        
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="trn">Save</span>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="btn_delete">
                        <span class="trn">Delete</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>