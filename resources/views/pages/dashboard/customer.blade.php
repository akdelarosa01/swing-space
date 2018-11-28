@extends('layouts.app')

@section('content')
    <div class="row">
    	<div class="col-md-4">
    		<div class="card">
    			<div class="card-body">
    				<div class="row justify-content-center">
						<img src="{{ asset('img/qr_code.png') }}" alt="QR Code" id="qr_code" class="img-fluid mb-1">
					</div>
					
					<p class="text-center" id="cust_code"></p>
    			</div>
    		</div>

    		<div class="card">
    			<div class="card-header trn">Available Refund Points</div>
    			<div class="card-body">
    				<div class="row justify-content-center">
						<h2 id="available_points"></h2>
					</div>
    			</div>
    		</div>
    	</div>

        <div class="col-md-8">
	    	<div class="col-md-12">
	        	<div class="card">
	        		<div class="card-header trn">My Bill for Today</div>
	        		<div class="card-body">
	        			<div class="table-responsive">
	        				<table class="table" id="tbl_bill">
	        					<thead>
	        						<th class="trn">Product</th>
	        						<th class="trn">Qty/Hrs</th>
	        						<th class="trn">Price</th>
	        					</thead>
	        					<tbody id="tbl_bill_body"></tbody>
	        				</table>
	        			</div>

	        			<div class="row">
	        				<div class="col-md-11 text-right">
	        					<h2 id="total_bill"></h2>
	        				</div>
	        			</div>
	        		</div>
	        	</div>
	        </div>

	        <div class="col-md-12">
				<div class="card">
	    			<div class="card-header trn">Referred Customers</div>
	    			<div class="card-body">
	    				<table class="table table-sm table-striped" width="100%" id="tbl_referred">
	    					<thead>
	    						<th></th>
		    					<th class="trn">Code</th>
		    					<th class="trn">First Name</th>
		    					<th class="trn">Last Name</th>
	    					</thead>
	    				</table>
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
