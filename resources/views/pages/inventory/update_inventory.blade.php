@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span data-localize="update_inventory.title">Update Inventory</span>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="input-group input-group-sm col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Item Type</span>
                    </div>
                    <select class="form-control form-control-sm" id="item_type"></select>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-info" id="btn_search_type">
                            <span data-localize="inventory_list.search">Search</span>
                        </button>
                    </div>
                </div>
            </div>

            <form action="../../update-inventory/save" method="post" id="frm_update">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-sm" id="tbl_items">
                        <thead>
                            <tr>
                                <th width="15%">Item Code</th>
                                <th width="25%">Item Name</th>
                                <th width="20%">Item Type</th>
                                <th width="10%">Quantity</th>
                                <th width="10%">Minimum Stock</th>
                                <th width="10%">UoM</th>
                                <th width="10%">New Qty</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_items_body"></tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-info btn-block">Save</button>
                    </div>
                </div>
            </form>


        </div>
    </div>

    @include('partials.modal_update_inventory')

@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/inventory/update_inventory.js') }}"></script>
@endpush
