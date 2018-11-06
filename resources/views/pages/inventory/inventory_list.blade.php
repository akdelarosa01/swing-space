@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Inventories
            <ul class="actions top-right">
                <li>
                    <a href="{{ url('/receive-items') }}" class="btn btn-sm btn-info btn-rounded btn-outline">
                        Receive Items
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tbl_items">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Item Code</th>
                            <th scope="col">Item Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Package</th>
                            <th scope="col">Pckg Qty</th>
                            <th scope="col">Remarks</th>
                            <th scope="col">Date Received</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="tbl_items_body"></tbody>
                </table>
            </div>

            <div class="row">
                <div class="offset-md-5 col-md-2">
                    <button type="button" class="btn btn-danger btn-block" id="btn_delete">Delete</button>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/inventory_list.js') }}"></script>
@endpush
