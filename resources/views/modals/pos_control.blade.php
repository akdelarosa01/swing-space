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
                        <td width="10%">Code</td>
                        <td width="45%">Firstname</td>
                        <td width="40%">Lastname</td>
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
                <input type="hidden" name="type" value="walkin">
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
                    <div class="form-group row">
                        <label for="walk_timein" class="control-label text-right col-md-3 trn">Time In</label>
                        <div class="col-md-9">
                            <input type="time" class="form-control form-control-sm clear validate" id="walk_timein" name="cust_timein">
                            <div id="walk_timein_feedback"></div>
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
            <div class="modal-body"></div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                    <span class="trn">Cancel</span>
                </button>
            </div>
        </div>
    </div>
</div>