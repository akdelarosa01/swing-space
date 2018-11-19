@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Hour Rate Settings</span>
                </div>
                <div class="card-body">
                    <form action="../../general-settings/save-rate" method="post" class="form-horizontal" id="frm_rate">
                        <input type="hidden" id="hr_token" name="_token" value="{{ Session::token() }}">
                        <input type="hidden" id="hr_id" name="hr_id">
                        <div class="form-group row">
                            <label for="hr" class="control-label text-right col-md-3 trn">Hours</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control form-control-sm clear" id="hr" name="hr" min="1" required>
                                <div id="hr_feedback"></div>
                            </div>
                            <label for="rate" class="control-label text-right col-md-3 trn">Rate</label>
                            <div class="col-md-9">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₱</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm clear" id="rate" name="rate" required>
                                    
                                </div>
                                <div id="rate_feedback"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-md-8 col-md-4">
                                <button type="submit" class="btn btn-sm btn-info btn-block">Set</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-sm" id="tbl_rate" width="100%">
                        <thead>
                            <th>Hrs</th>
                            <th>Rate</th>
                            <th></th>
                        </thead>
                        <tbody id="tbl_rate_body"></tbody>
                    </table>
                </div>
            </div>
        </div>

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
                                <button type="submit" class="btn btn-sm btn-info btn-block">Set</button>
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

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Incentive Settings</span>
                    <button type="button" class="btn btn-sm btn-success pull-right" id="btn_add_itcentive">
                        <span class="trn">Add New Incentive</span>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="tbl_incentive" width="100%">
                        <thead>
                            <th class="trn">Code</th>
                            <th class="trn">Name</th>
                            <th class="trn">Points</th>
                            <th class="trn">Hours</th>
                            <th class="trn">Days</th>
                            <th class="trn">Space</th>
                            <th class="trn">Description</th>
                            <th></th>
                        </thead>
                        <tbody id="tbl_incentive_body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Reward Settings</span>
                    <button type="button" class="btn btn-sm btn-success pull-right" id="btn_add_reward">
                        <span class="trn">Add New Reward</span>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="tbl_reward" width="100%">
                        <thead>
                            <th class="trn">Code</th>
                            <th class="trn">Name</th>
                            <th class="trn">Points</th>
                            <th class="trn">Hours</th>
                            <th class="trn">Days</th>
                            <th class="trn">Space</th>
                            <th class="trn">Description</th>
                            <th></th>
                        </thead>
                        <tbody id="tbl_incentive_body"></tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    @include('modals.general_settings')
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/settings/general_settings.js') }}"></script>
@endpush
