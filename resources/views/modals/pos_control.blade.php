<div class="modal fade" id="member_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Customer Info</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="search_code" class="control-label text-right col-md-3 trn">Customer Code</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control form-control-sm clear validate" id="search_code">
                        <div id="search_code_feedback"></div>
                    </div>
                </div>
                <table class="table table-sm" id="tbl_members" width="100%">
                    <thead>
                        <td width="10%" class="trn">Code</td>
                        <td width="45%" class="trn">First Name</td>
                        <td width="40%" class="trn">Last Name</td>
                        <td width="5%"></td>
                    </thead>
                    <tbody id="tbl_members_body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="walkin_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Customer Info</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <form action="../../pos-control/current-customer" method="post" class="form-horizontal" id="frm_walkin">
                @csrf
                <input type="hidden" id="id" class="clear" name="id">
                <input type="hidden" name="type" value="W">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="walk_firstname" class="control-label text-right col-md-3 trn">First Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-sm clear validate" id="walk_firstname" name="cust_firstname">
                            <div id="walk_firstname_feedback"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="walk_lastname" class="control-label text-right col-md-3 trn">Last Name</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control form-control-sm clear validate" id="walk_lastname" name="cust_lastname">
                            <div id="walk_lastname_feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-info btn-sm">
                        <span class="trn">Check In</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="discount_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Discounts</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm" id="tbl_discounts" width="100%">
                    <thead>
                        <th>Description</th>
                        <th>Percentage</th>
                        <th></th>
                    </thead>
                    <tbody id="tbl_discounts_body"></tbody>
                </table>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                    <span class="trn">Cancel</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rewards_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Rewards</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
             <div class="modal-body">
                <div class="form-group row">
                    <label for="points_used" class="control-label text-right col-md-3 trn">Points to use</label>
                    <div class="col-md-9">
                        <input type="number" class="form-control form-control-sm clear validate" id="points_used" name="points_used">
                        <div id="points_used_feedback"></div>
                    </div>
                </div>

                <input type="hidden" id="price_deducted" name="price_deducted">
                <input type="hidden" id="available_points" name="available_points">
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-info btn-sm" id="btn_calculateRewards">
                    <span class="trn">Use Points</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="change_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span class="trn">Change</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm" id="tbl_rewards" width="100%" style="font-size: 28px">
                    <thead>
                        <th>Change:</th>
                        <th id="change_view">0.00</th>
                    </thead>
                </table>
                <input type="hidden" name="order_change" id="order_change" value="0.00">
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                    <span class="trn">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="menu_modal" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="detail_fullname"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="zmdi zmdi-close"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="data-cust_code" id="data-cust_code" /> 
                    <input type="hidden" name="data-cust_firstname" id="data-cust_firstname" /> 
                    <input type="hidden" name="data-cust_lastname" id="data-cust_lastname" /> 
                    <input type="hidden" name="data-customer_type" id="data-customer_type" /> 
                    <input type="hidden" name="data-customer_user_id" id="data-customer_user_id" /> 
                    <input type="hidden" name="data-points" id="data-points" /> 
                    <input type="hidden" name="data-cust_id" id="data-cust_id" />

                    <div class="col-md-6">
                        <button class="btn btn-lg btn-block btn-info" id="btn_view_pos">ORDER</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-lg btn-block btn-danger" id="btn_cancel_customer">CANCEL</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                    <span class="trn">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>