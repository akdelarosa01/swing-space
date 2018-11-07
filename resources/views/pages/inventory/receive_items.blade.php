@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">Receive Items</div>
                <form action="../../receive-items/save" method="post" class="form-horizontal" id="frm_items">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="item_name" class="control-label text-right col-md-3">Item Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control form-control-sm" id="item_name" name="item_name">
                                <div id="item_name_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="item_type" class="control-label text-right col-md-3">Item Type</label>
                            <div class="col-md-8">
                                <select name="item_type" id="item_type" class="form-control form-control-sm"></select>
                                <div id="item_type_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantity" class="control-label text-right col-md-3">Quantity</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control form-control-sm" id="quantity" name="quantity" maxlength="5">
                                <div id="quantity_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="package" class="control-label text-right col-md-3">Package</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-sm" id="package" name="package"></select>
                                <div id="package_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="package_qty" class="control-label text-right col-md-3">Package Qty.</label>
                            <div class="col-md-8">
                                <input type="number" class="form-control form-control-sm" id="package_qty" name="package_qty" maxlength="3">
                                <div id="package_qty_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="remarks" class="control-label text-right col-md-3">Remarks</label>
                            <div class="col-md-8">
                                <textarea class="form-control form-control-sm" id="remarks" name="remarks"></textarea>
                                <div id="remarks_feedback"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <button type="button" class="btn btn-info btn-sm">Submit</button>
                        <button type="button" class="btn btn-secondary btn-sm clear-form">Clear</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-9">
                            <div class="custom-file mb-1">
                                <input type="file" class="custom-file-input form-control-sm" id="inventory_file">
                                <label class="custom-file-label" for="inventory_file">Choose xlsx file</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-info btn-sm btn-block mb-3">Upload</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tbl_items">
                            <thead>
                                <tr>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Item Type</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Package</th>
                                    <th scope="col">Pckg Qty</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl_items_body">
                                <tr>
                                    <td colspan="7" class="text-center">No data displayed.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info btn-sm pull-right">Save</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/inventory/receive_items.js') }}"></script>
@endpush
