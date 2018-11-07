@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">Transaction Codes</h5>
        <div class="card-body">

            <div class="row">
                <div class="col-md-5">
                    <form method="post" id="frm_trans_code" action="/admin/transaction-codes/save">
                        @csrf
                        <input type="hidden" id="id" name="id" class="clear">

                        <div class="form-group row">
                            <label for="code" class="col-sm-3 col-form-label">Code</label>
                            <div class="col-sm-9">
                                <input type="text" id="code" name="code" class="form-control form-control-sm clear validate">
                                <div id="code_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea id="description" name="description" cols="30" rows="3" style="resize:none" class="form-control clear validate"></textarea>
                                <div id="description_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="prefix" class="col-sm-3 col-form-label">Prefix</label>
                            <div class="col-sm-9">
                                <input type="text" id="prefix" name="prefix" class="form-control form-control-sm clear validate">
                                <div id="prefix_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="prefix_format" class="col-sm-3 col-form-label">Prefix Format</label>
                            <div class="col-sm-9">
                                <input type="text" id="prefix_format" name="prefix_format" class="form-control form-control-sm clear validate">
                                <div id="prefix_format_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="next_no" class="col-sm-3 col-form-label">Next no.</label>
                            <div class="col-sm-9">
                                <input type="number" id="next_no" name="next_no" class="form-control form-control-sm clear validate">
                                <div id="next_no_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="next_no_length" class="col-sm-3 col-form-label">Next no. length</label>
                            <div class="col-sm-9">
                                <input type="number" id="next_no_length" name="next_no_length" class="form-control form-control-sm clear validate">
                                <div id="next_no_length_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-danger btn-sm pull-left" id="btn_cancel">Cancel</button>
                                <button type="submit" class="btn btn-info btn-sm pull-right" >Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-7">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped" id="tbl_transaction" width="100%">
                            <thead>
                                <th width="15%">Code</th>
                                <th width="25%">Description</th>
                                <th width="15%">Prefix</th>
                                <th width="15%">Format</th>
                                <th width="10%">Next No.</th>
                                <th width="10%">Length</th>
                                <th width="10%"></th>
                            </thead>
                            <tbody id="tbl_transaction_body"></tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        let token = $('meta[name=csrf-token]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/super_admin/transaction_codes.js') }}"></script>
@endpush