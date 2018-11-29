@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="trn">Inventories</span>
            <a href="{{ url('/item-output') }}" class="btn btn-sm btn-info btn-rounded btn-outline pull-right">
                <span class="trn">Item Output</span>
            </a>
            <a href="{{ url('/receive-items') }}" class="btn btn-sm btn-info btn-rounded btn-outline pull-right">
                <span class="trn">Receive Item</span>
            </a>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="input-group input-group-sm offset-md-6 col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text trn">Item Type</span>
                    </div>
                    <select class="form-control form-control-sm" id="item_type"></select>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-info" id="btn_search_type">
                            <span class="trn">Search</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tbl_items">
                    <thead>
                        <tr>
                            <th scope="col" class="trn">Item Code</th>
                            <th scope="col" class="trn">Item Name</th>
                            <th scope="col" class="trn">Item Type</th>
                            <th scope="col" class="trn">Quantity</th>
                            <th scope="col" class="trn">Minimum Stock</th>
                            <th scope="col" class="trn">UoM</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_items_body"></tbody>
                </table>
            </div>

            <div class="row">
                <div class="offset-md-10 col-md-2">
                    <button class="btn btn-sm btn-success btn-block trn" id="btn_export">Export Files</button>
                </div>
            </div>

        </div>
    </div>
    @include('modals.inventory_list')
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/inventory/inventory_list.js') }}"></script>
@endpush
