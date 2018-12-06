<div class="modal fade" id="sales_per_customer_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Sales per Customer</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="customer_from" class="control-label text-right col-md-3 trn">From</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control form-control-sm" id="customer_from">
                        <div id="customer_from_feedback"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="customer_to" class="control-label text-right col-md-3 trn">To</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control form-control-sm" id="customer_to">
                        <div id="customer_to_feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-success btn-sm clear-form" id="sales_per_customer">
                    <span class="trn">Export</span>
                </button>
                <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                    <span class="trn">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="sales_vs_discount_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Sales vs. Discount</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="discount_from" class="control-label text-right col-md-3 trn">From</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control form-control-sm" id="discount_from">
                        <div id="discount_from_feedback"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="discount_to" class="control-label text-right col-md-3 trn">To</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control form-control-sm" id="discount_to">
                        <div id="discount_to_feedback"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-success btn-sm clear-form" id="sales_vs_discount">
                    <span class="trn">Export</span>
                </button>
                <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                    <span class="trn">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>