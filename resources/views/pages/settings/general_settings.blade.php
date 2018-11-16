@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <span class="trn">Incentive Settings</span>
                            <button type="button" class="btn btn-sm btn-success pull-right" id="btn_add_itcentive">
                                <span class="trn">Add New Incentive</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm" id="tbl_incentive">
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
                            <table class="table table-sm" id="tbl_reward">
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
        </div>


        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header">
                    <span class="trn">General Settings</span>
                </div>
                <div class="card-body">
                    <form action="#" class="form-horizontal">
                        <div class="form-body">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Employee discount</label>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm" value="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Senior discount</label>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control form-control-sm" value="0">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light">
                    <div class="form-actions">
                        <div class="row">
                            <div class="offset-sm-5 col-md-6">
                                <button class="btn btn-sm btn-info btn-rounded">Set</button>
                                <button class="btn btn-sm btn-secondary clear-form btn-rounded btn-outline">Cancel</button>
                            </div>
                        </div>
                    </div>
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
