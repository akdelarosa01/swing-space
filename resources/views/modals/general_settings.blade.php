<div class="modal fade" id="incentive_modal" role="dialog" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">
					<span class="trn">Incentive Settings</span>
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
                        <label for="inc_name" class="control-label text-right col-md-3 trn">Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-sm clear" id="inc_name" name="inc_name">
                            <div id="inc_name_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inc_points" class="control-label text-right col-md-3 trn">Points</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="inc_points" name="inc_points">
                            <div id="inc_points_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inc_hrs" class="control-label text-right col-md-3 trn">Hours Required</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="inc_hrs" name="inc_hrs">
                            <div id="inc_hrs_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inc_days" class="control-label text-right col-md-3 trn">Days Required</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="inc_days" name="inc_days">
                            <div id="inc_days_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inc_space" class="control-label text-right col-md-3 trn">Space Required</label>
                        <div class="col-md-9">
                            <select class="form-control form-control-sm clear" id="inc_space" name="inc_space"></select>
                            <div id="inc_space_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inc_description" class="control-label text-right col-md-3 trn">Description</label>
                        <div class="col-md-9">
                            <textarea class="form-control form-control-sm clear" id="inc_description" name="inc_description"></textarea>
                            <div id="inc_description_feedback"></div>
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




<div class="modal fade" id="rewards_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Reward Settings</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <form action="../../general-settings/save-reward" class="form-horizontal" id="frm_reward">
                <input type="hidden" id="rwd_token" name="_token" value="{{ Session::token() }}">
                <div class="modal-body">
                    <input type="hidden" class="clear" id="rwd_id" name="rwd_id">
                    <div class="form-group row">
                        <label for="rwd_name" class="control-label text-right col-md-3 trn">Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-sm clear" id="rwd_name" name="rwd_name">
                            <div id="rwd_name_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rwd_points" class="control-label text-right col-md-3 trn">Points</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-sm clear" id="rwd_points" name="rwd_points">
                            <div id="rwd_points_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rwd_hrs" class="control-label text-right col-md-3 trn">Hours</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="rwd_hrs" name="rwd_hrs">
                            <div id="rwd_hrs_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rwd_days" class="control-label text-right col-md-3 trn">Days</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control form-control-sm clear" id="rwd_days" name="rwd_days">
                            <div id="rwd_days_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rwd_space" class="control-label text-right col-md-3 trn">Space</label>
                        <div class="col-md-9">
                            <select class="form-control form-control-sm clear" id="rwd_space" name="rwd_space"></select>
                            <div id="rwd_space_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rwd_description" class="control-label text-right col-md-3 trn">Description</label>
                        <div class="col-md-9">
                            <textarea class="form-control form-control-sm clear" id="rwd_description" name="rwd_description"></textarea>
                            <div id="rwd_description_feedback"></div>
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