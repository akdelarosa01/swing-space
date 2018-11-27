@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Customers Today</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm v-align-middle" id="tbl_customers">
                            <thead class="bg-light">
                                <tr>
                                    <th width="10%"></th>
                                    <th width="10%">Code</th>
                                    <th width="40%">Name</th>
                                    <th width="20%">Avail. Points</th>
                                    <th width="20%">Total Bill</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_customers_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-rounded icon-rounded-primary float-left m-r-20">
                                <i class="icon dripicons-user-group"></i>
                            </div>
                            <h5 class="card-title m-b-5 counter" id="total_customers"></h5>
                            <h6 class="text-muted m-t-10">
                                Total Registered Customer
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-rounded icon-rounded-accent float-left m-r-20">
                                <i class="icon dripicons-shopping-bag"></i>
                            </div>
                            <h5 class="card-title m-b-5 counter" id="total_sold_product"></h5>
                            <h6 class="text-muted m-t-10">
                                Total sold products today
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-rounded icon-rounded-info float-left m-r-20">
                                <i class="fa fa-money"></i>
                            </div>
                            <h5 class="card-title m-b-5 counter" id="total_earnings"></h5>
                            <h6 class="text-muted m-t-10">
                                Total earnings today
                            </h6>
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
    <script type="text/javascript" src="{{ asset('/js/pages/dashboard/employee.js') }}"></script>
@endpush
