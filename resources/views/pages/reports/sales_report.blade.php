@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="trn">Sales</span>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="input-group input-group-sm offset-md-6 col-md-6">
                    <div class="input-group-prepend">
                        <span class="input-group-text trn">From</span>
                    </div>

                    <input type="date" id="datefrom" name="datefrom" class="form-control form-control-sm">

                    <div class="input-group-append">
                        <span class="input-group-text trn">To</span>
                    </div>

                    <input type="date" id="dateto" name="dateto" class="form-control form-control-sm">

                    <div class="input-group-append">
                        <button type="button" class="btn btn-sm btn-info" id="btn_generate">
                            <span class="trn">Generate</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-sm table-striped" id="tbl_sales" width="100%">
                        <thead>
                            <th>Customer Code</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Customer Type</th>
                            <th>Total Sale</th>
                            <th>Date</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <span class="trn">Total amount of Customer's purchased</span>
            <button type="button" class="btn btn-sm btn-success btn-rounded btn-outline pull-right btn-permission" id="btn_customer">
                <span class="trn">Export</span>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="SalesFromCustomer" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <span class="trn">Total sales Vs. Total Discounts</span>
            <button type="buton" class="btn btn-sm btn-success btn-rounded btn-outline pull-right btn-permission" id="btn_discount">
                <span class="trn">Excel</span>
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="SalesOverDiscounts" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
            
        </div>
    </div>
	<div class="card">
		<div class="card-header">
            <span class="trn">Yearly Comparison Sales Report</span>
            {{-- <a href="{{ url('/sales-report/yearly-comparison-excel') }}" class="btn btn-sm btn-success btn-rounded btn-outline pull-right">
                <span class="trn">Excel</span>
            </a> --}}
        </div>
		<div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="YearlyComparisonReport" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
			
		</div>
	</div>

    @include('modals.sales_report')
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/reports/sales_report.js') }}"></script>
@endpush
