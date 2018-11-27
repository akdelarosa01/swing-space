@extends('layouts.app')

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		<div class="row">
    			<div class="col-md-12">
    				<div class="card">
		    			<div class="card-body">
		    				<div class="row justify-content-center">
								<img src="{{ asset('img/qr_code.png') }}" alt="QR Code" id="cust_code_qr" class="img-fluid mb-1">
							</div>
							
							<p class="text-center" id="cust_code"></p>
		    			</div>
		    		</div>
    			</div>
    		</div>	
    	</div>

        <div class="col-md-9">
        	<div class="row">
    			<div class="col-md-5">
		        	<div class="card">
		    			<div class="card-header">Available Refund Points</div>
		    			<div class="card-body">
		    				<div class="row justify-content-center">
								<h3 id="available_points"></h3>
							</div>
		    			</div>
		    		</div>

		    		<div class="card">
		    			<div class="card-header">Time spent today</div>
		    			<div class="card-body">
		    				<div class="row justify-content-center">
								<h3 id="time_spent"></h3>
							</div>
		    			</div>
		    		</div>
		    	</div>

		    	<div class="col-md-7">
		        	<div class="card">
		        		<div class="card-header">My Bill for Today</div>
		        		<div class="card-body">
		        			<div class="table-responsive">
		        				<table class="table" id="tbl_bill">
		        					<thead>
		        						<th>Product</th>
		        						<th>Qty/Hrs</th>
		        						<th>Price</th>
		        					</thead>
		        					<tbody id="tbl_bill_body"></tbody>
		        				</table>
		        			</div>

		        			<div class="row">
		        				<div class="col-md-11 text-right">
		        					<span id="total_bill"></span>
		        				</div>
		        			</div>
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
    <script type="text/javascript" src="{{ asset('/js/pages/dashboard/customer.js') }}"></script>
@endpush
