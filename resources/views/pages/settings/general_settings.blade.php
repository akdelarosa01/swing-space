@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Discount Settings</span>
                </div>
                <div class="card-body">
                    <form action="../../general-settings/save-discount" method="post" class="form-horizontal" id="frm_discount">
                        <input type="hidden" id="dis_token" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" id="discount_id" name="discount_id">
                        <div class="form-group row">
                            <label for="discount" class="control-label text-right col-md-3 trn">Name</label>
                            <div class="col-md-9">
                                <select class="form-control form-control-sm clear" id="discount" name="description"></select>
                                <div id="discount_feedback"></div>
                            </div>
                            <label for="percentage" class="control-label text-right col-md-3 trn">Percent</label>
                            <div class="col-md-9">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm clear" id="percentage" name="percentage">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div id="percentage_feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-md-8 col-md-4">
                                <button type="submit" class="btn btn-sm btn-info btn-block trn">Set</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-sm" id="tbl_discount" width="100%">
                        <thead>
                            <th>Name</th>
                            <th>Percent</th>
                            <th></th>
                        </thead>
                        <tbody id="tbl_discount_body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Goal Settings</span>
                    <button type="button" class="btn btn-sm btn-success pull-right" id="btn_add_itcentive">
                        <span class="trn">Add New Goal</span>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="tbl_incentive" width="100%">
                        <thead>
                            <th class="trn">Price From</th>
                            <th class="trn">Price To</th>
                            <th class="trn">Points</th>
                            <th></th>
                        </thead>
                        <tbody id="tbl_incentive_body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Reward Settings</span>
                </div>
                <div class="card-body">
                    <form action="../../general-settings/save-reward" class="form-horizontal" id="frm_reward">
                        <input type="hidden" class="clear" id="rwd_id" name="rwd_id">
                        <div class="form-group row">
                            <label for="deducted_price" class="control-label text-right col-md-3 trn">Discount Price</label>
                            <div class="col-md-9">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₱</span>
                                    </div>
                                    <input type="number" class="form-control form-control-sm clear validate" id="deducted_price" name="deducted_price" min="1" step="any">
                                    <div id="deducted_price_feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deducted_points" class="control-label text-right col-md-3 trn">Points Equivalent</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm clear" id="deducted_points" name="deducted_points">
                                <div id="deducted_points_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-md-8 col-md-4">
                                <button type="submit" class="btn btn-info btn-sm">
                                    <span class="trn">Save</span>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm clear-form" data-dismiss="modal">
                                    <span class="trn">Cancel</span>
                                </button>
                            </div>
                                
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Promo for POS Customer View Settings</span>
                    <button type="button" class="btn btn-sm btn-success pull-right" id="btn_add_promo">
                        <span class="trn">Add Promo</span>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="tbl_promo" width="100%">
                        <thead>
                            <th class="trn">Photo</th>
                            <th class="trn">Description</th>
                            <th></th>
                        </thead>
                        <tbody id="tbl_promo_body"></tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    @include('modals.general_settings')
    @include('modals.global')
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/settings/general_settings.js') }}"></script>
@endpush
