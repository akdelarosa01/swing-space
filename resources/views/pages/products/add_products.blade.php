@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Products</span>
                    <button type="button" class="btn btn-sm btn-success pull-right" id="btn_add_products" class="trn">
                        <span class="trn">Add New Product</span>
                    </button>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tbl_availables">
                            <thead>
                                <tr>
                                    <th scope="col" class="trn">Code</th>
                                    <th scope="col" class="trn">Product Name</th>
                                    <th scope="col" class="trn">Variants</th>
                                    <th scope="col" class="trn">Price</th>
                                    <th scope="col" class="trn">Target Qty.</th>
                                    <th scope="col" class="trn">Avail. Qty.</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl_availables_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Set New Available Quantity</span>
                </div>
                <div class="card-body">
                    <form action="../../add-products/set-qty" id="frm_set_qty" method="post">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="tbl_selected">
                                <thead>
                                    <tr>
                                        <th width="10%" class="trn">Code</th>
                                        <th width="20%" class="trn">Product Name</th>
                                        <th width="20%" class="trn">Variants</th>
                                        <th width="10%" class="trn">Price</th>
                                        <th width="15%" class="trn">Target Qty.</th>
                                        <th width="15%" class="trn">Avail. Qty.</th>
                                        <th width="10%" class="trn"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_selected_body"></tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-sm btn-info pull-right btn-permission">
                                    <span class="trn">Save</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('modals.add_products')
    @include('modals.global')
    
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/products/add_products.js') }}"></script>
@endpush
