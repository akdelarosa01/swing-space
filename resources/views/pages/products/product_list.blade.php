@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span data-localize="product.title">Products</span>
            <ul class="actions top-right">
                <li>
                    <a href="{{ url('/add-products') }}" class="btn btn-sm btn-info btn-rounded btn-outline">Add Products</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tbl_products">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Product Type</th>
                            <th scope="col">Price</th>
                            <th scope="col">Variants</th>
                            <th scope="col">Target Qty.</th>
                            <th scope="col">Avail. Qty.</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_products_body"></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/products/product_list.js') }}"></script>
@endpush
