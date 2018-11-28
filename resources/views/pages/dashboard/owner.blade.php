@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="icon-rounded icon-rounded-primary float-left m-r-20">
                        <i class="icon dripicons-user-group"></i>
                    </div>
                    <h5 class="card-title m-b-5 counter" id="total_customers"></h5>
                    <h6 class="text-muted m-t-10 trn">Total registered customers</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="icon-rounded icon-rounded-accent float-left m-r-20">
                        <i class="icon dripicons-user-group"></i>
                    </div>
                    <h5 class="card-title m-b-5 counter" id="total_employees"></h5>
                    <h6 class="text-muted m-t-10 trn">Total employees</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="icon-rounded icon-rounded-info float-left m-r-20">
                        <i class="icon dripicons-shopping-bag"></i>
                    </div>
                    <h5 class="card-title m-b-5 counter" id="total_products"></h5>
                    <h6 class="text-muted m-t-10 trn">Total registered products</h6>
                </div>
            </div>
        </div>

        <div class="col-md-12">
        	<div class="card">
				<h5 class="card-header trn">Sales</h5>
				<div class="card-body p-10">
					  <h5 class="card-title secondary-type m-b-0 m-l-10" id="weekly_sale"></h5>
						<small class="text-muted m-l-10"><span class="trn">Week of</span> <span id="start_date"></span> - <span id="end_date"></span></small>
					<div id="ct-LineChart1" class="chartist-primary">
						<div class="ct-chart"></div>
					</div>
				</div>
			</div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <h5 class="card-header trn">Monthly Sales per Registered Customers</h5>
                <div class="card-body">
                    <table class="table table-sm table-striped" width="100%" id="tbl_registered">
                        <thead>
                            <th></th>
                            <th class="trn">Code</th>
                            <th class="trn">Name</th>
                            <th class="trn">Points</th>
                            <th class="trn">Sales</th>
                        </thead>
                        <tbody id="tbl_registered_body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/dashboard/owner.js') }}"></script>
@endpush
