@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="trn">Wrong Sales Deletion</span>
        </div>
        <div class="card-body">
            <div class="loading"></div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-sm" id="tbl_products" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="check_all_products">
                                </th>
                                <th>Customer Code</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Product Type</th>
                                <th>Variants</th>
                                <th>Quantity</th>
                                <th>Cost</th>
                                <th>Customer Type</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_products_body"></tbody>
                    </table>

                    <button class="btn btn-sm btn-danger" id="btn_delete_products"> Delete Sold Products</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-sm" id="tbl_sales" width="100%">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" class="check_all_sales">
                                </th>
                                <th>Customer Code</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Sub Total</th>
                                <th>Discount</th>
                                <th>Payment</th>
                                <th>Change</th>
                                <th>Total Sale</th>
                                <th>Customer Type</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_sales_body"></tbody>
                    </table>

                    <button class="btn btn-sm btn-danger" id="btn_delete_sales"> Delete Sales</button>
                </div>
            </div>

            
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/super_admin/wrong_sales_deletion.js') }}"></script>
@endpush