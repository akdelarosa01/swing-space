@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="trn">Products</span>
            <ul class="actions top-right">
                <li>
                    <a href="{{ url('/add-products') }}" class="btn btn-sm btn-info btn-rounded btn-outline pull-right">
                        <span class="trn">Product Registration</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tbl_products">
                    <thead>
                        <tr>
                            <th scope="col" class="trn">Code</th>
                            <th scope="col" class="trn">Product Name</th>
                            <th scope="col" class="trn">Description</th>
                            <th scope="col" class="trn">Product Type</th>
                            <th scope="col" class="trn">Price</th>
                            <th scope="col" class="trn">Variants</th>
                            <th scope="col" class="trn">Target Qty.</th>
                            <th scope="col" class="trn">Avail. Qty.</th>
                            <th scope="col" class="trn">Update Date</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_products_body"></tbody>
                </table>
            </div>

            <div class="row">
                <div class="offset-md-10 col-md-2">
                    <button class="btn btn-sm btn-success btn-block" id="btn_export">
                        <span class="trn">Export Files</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @include('modals.product_list')
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/products/product_list.js') }}"></script>
@endpush
