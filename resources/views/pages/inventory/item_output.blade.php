@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <span data-localize="item_output.title">Item Output</span>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="input-group input-group-sm col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Item Type</span>
                            </div>
                            <select class="form-control form-control-sm" id="item_type_srch"></select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" id="btn_search_type">
                                    <span data-localize="item_output.search">Search</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered table-striped" id="tbl_items">
                        <thead>
                            <tr>
                                <th width="20%">Item Code</th>
                                <th width="30%">Item Name</th>
                                <th width="20%">Avail. Qty.</th>
                                <th width="20%">UoM</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody id="tbl_items_body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <form action="../../item-output/save-selected" method="post" id="frm_selected">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="tbl_selected">
                                <thead>
                                    <tr>
                                        <th width="20%">Item Code</th>
                                        <th width="40%">Item Name</th>
                                        <th width="20%">Item Type</th>
                                        <th width="20%">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_selected_body"></tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-sm pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/inventory/item_output.js') }}"></script>
@endpush
