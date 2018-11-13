@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
        	<form class="form-inline">
				<label class="sr-only" for="customer_id">Customer ID</label>
				<input type="text" class="form-control form-control-sm mb-2 mr-sm-2" id="customer_id" placeholder="Customer ID" autofocus>

				<button type="submit" class="btn btn-sm btn-info mb-2">Search</button>
			</form>
        </div>
    </div>

    <div class="row">
    	<div class="col-md-8">
    		<div class="card">
				<form>
					<div class="card-body">
						<div class="form-group row">
							<div class="col-md-6">
								<input type="text" class="form-control form-control-sm" id="cust_name" name="cust_name" placeholder="Customer Name">
							</div>
							<div class="col-md-6">
								<select class="form-control form-control-sm" id="item" name="item">
									<option value="">Select Items</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table table-sm">
										<thead>
											<tr>
												<th width="5%">#</th>
												<th width="35%">Description</th>
												<th width="15%" class="text-right">QTY</th>
												<th width="15%" class="text-right">Unit Price</th>
												<th width="15%" class="text-right">Total</th>
												<th width="15%"></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Chocolate Cake</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="5">
												</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="Php 100" readonly>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="Php 500" readonly>
												</td>
												<td>
													<button type="button" class="btn btn-sm btn-danger btn-outline">
														Remove
													</button>
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>Hot Coffee</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="5">
												</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="Php 70" readonly>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="Php 350" readonly>
												</td>
												<td>
													<button type="button" class="btn btn-sm btn-danger btn-outline">
														Remove
													</button>
												</td>
											</tr>
											<tr>
												<td>3</td>
												<td>Hour Rent</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="2">
												</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="Php 250" readonly>
												</td>
												<td>
													<input type="text" class="form-control form-control-sm" value="Php 500" readonly>
												</td>
												<td>
													<button type="button" class="btn btn-sm btn-danger btn-outline">
														Remove
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer bg-light">
						<button type="button" class="btn btn-sm btn-info">Add to Bill</button>
						<button type="button" class="btn btn-sm btn-secondary clear-form">Clear</button>
					</div>
				</form>
			</div>
    	</div>

    	<div class="col-md-4">
    		<div class="card">
    			<div class="card-body">
    				<table class="table">
    					<tbody>
    						<tr>
    							<td>Sub Total:</td>
    							<td>Php 1,350</td>
    						</tr>
    						<tr>
    							<td>Points Refund:</td>
    							<td>Php 50.00</td>
    						</tr>
    						<tr>
    							<td></td>
    							<td>
    								<h1>Php 1,300</h1>
    							</td>
    						</tr>
    						<tr>
    							<td>Refund Points?</td>
    							<td>
    								<select name="refund" id="refund" class="form-control form-control-sm">
    									<option value="0">No</option>
    									<option value="0">Yes</option>
    								</select>
    							</td>
    						</tr>
    					</tbody>
    				</table>
    			</div>
    			<div class="card-footer bg-light">
					<a href="{{ url('employee/checkout') }}" class="btn btn-sm btn-info btn-outline">Payment</a>
				</div>
    		</div>
    	</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
var token = $('meta[name="csrf-token"]').attr('content');
</script>
@endpush
