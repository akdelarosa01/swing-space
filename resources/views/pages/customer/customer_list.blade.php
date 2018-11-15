@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="trn">Customer List</span>
            <a href="{{ url('/membership') }}" class="btn btn-sm btn-info btn-rounded btn-outline pull-right">
                <span class="trn">Membership</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tbl_customers">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="30%" class="trn">Code</th>
                            <th width="30%" class="trn">Name</th>
                            <th width="30%" class="trn">Gender</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody id="tbl_customers_body"></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/customer/customer_list.js') }}"></script>
@endpush
