@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Receive Item</span>
                    <button type="button" class="btn btn-sm btn-success pull-right" id="btn_add_items">
                        <span class="trn">Add New Item</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="input-group input-group-sm col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text trn">Item Type</span>
                            </div>
                            <select class="form-control form-control-sm" id="item_type_srch"></select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-sm btn-info" id="btn_search_type">
                                    <span class="trn">Search</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered table-striped" id="tbl_items">
                        <thead>
                            <tr>
                                <th width="20%" class="trn">Item Code</th>
                                <th width="30%" class="trn">Item Name</th>
                                <th width="20%" class="trn">Avail. Qty.</th>
                                <th width="20%" class="trn">UoM</th>
                                <th width="10%" class="trn"></th>
                            </tr>
                        </thead>
                        <tbody id="tbl_items_body"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    {{-- <form enctype="multipart/form-data" method="post" action="../../receive-items/upload-inventory" id="frm_upload_inventory">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="custom-file mb-1">
                                    <input type="file" class="custom-file-input form-control-sm" id="inventory_file" name="inventory_file">
                                    <label class="custom-file-label trn" for="inventory_file">Choose xlsx file</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-info btn-sm btn-block mb-3">
                                    <span class="trn">Upload</span>
                                </button>
                            </div>
                        </div>
                    </form> --}}

                    <form action="../../receive-items/save-selected" method="post" id="frm_selected">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="tbl_selected">
                                <thead>
                                    <tr>
                                        <th width="20%" class="trn">Item Code</th>
                                        <th width="40%" class="trn">Item Name</th>
                                        <th width="20%" class="trn">Item Type</th>
                                        <th width="10%" class="trn">Quantity</th>
                                        <th width="10%" class="trn"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_selected_body"></tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-sm pull-right">
                                    <span class="trn">Save</span>
                                </button>
                                {{-- <button type="button" class="btn btn-success btn-sm" id="btn_download_format">Download Upload Format</button> --}}
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    @include('modals.receive_items')
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/inventory/receive_items.js') }}"></script>
@endpush
