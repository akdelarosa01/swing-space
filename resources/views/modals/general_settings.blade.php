<div class="modal fade" id="incentive_modal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<span class="trn">Goal Settings</span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true" class="zmdi zmdi-close"></span>
				</button>
			</div>
			<form action="../../general-settings/save-incentive" class="form-horizontal" id="frm_incentive">
				<input type="hidden" id="inc_token" name="_token" value="{{ Session::token() }}">
                <div class="modal-body">
                    <input type="hidden" class="clear" id="inc_id" name="inc_id">
                    <div class="form-group row">
                        <label for="price_from" class="control-label text-right col-md-3 trn">Price From</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="price_from" name="price_from" min="1" step="any">
                            <div id="price_from_feedback"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="price_to" class="control-label text-right col-md-3 trn">Price To</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="price_to" name="price_to" min="1" step="any">
                            <div id="price_to_feedback"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="points" class="control-label text-right col-md-3 trn">Points</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="points" name="points">
                            <div id="points_feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="trn">Save</span>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                        <span class="trn">Cancel</span>
                    </button>
                </div>
            </form>
		</div>
	</div>
</div>

<div class="modal fade" id="promo_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Promo for POS Customer View Settings</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <form action="../../general-settings/save-promo" class="form-horizontal" id="frm_promo" enctype="multipart/form-data" method="post">
                <input type="hidden" id="promo_token" name="_token" value="{{ Session::token() }}">
                <div class="modal-body">
                    <input type="hidden" class="clear" id="promo_id" name="promo_id">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="promo_photo" name="promo_photo">
                                <label class="custom-file-label trn" for="promo_photo">Choose Photo</label>
                             </div>
                            <div id="promo_photo_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea class="form-control form-control-sm clear" id="promo_desc" name="promo_desc" placeholder="Promo Description.."></textarea>
                            <div id="promo_desc_feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="trn">Save</span>
                    </button>
                    <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                        <span class="trn">Cancel</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>