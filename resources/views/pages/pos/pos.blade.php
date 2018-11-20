@extends('layouts.app')

@section('content')

	<div id="customers">
		<div class="row no-gutters">
			<div class="col-md-2 ml-1 mb-1">
				<button type="button" class="btn btn-lg btn-block btn-danger btn-outline" id="btn_walkin">
					<span class="trn" style="font-size:12px;word-wrap: break-word;">Walk-in</span>
				</button>
			</div>
			<div class="col-md-2 ml-1 mb-1">
				<button type="button" class="btn btn-lg btn-block btn-danger btn-outline" id="btn_member">
					<span class="trn" style="font-size:12px;word-wrap: break-word;">Members</span>
				</button>
			</div>
		</div>

		<div class="row no-gutters" id="current_customers"></div>
	</div>

	<div id="pos_control">
		<div class="row no-gutters" id="product_types"></div>
	    <hr/>

		<div class="row">
			<div class="col-md-6">
				<div class="row no-gutters" id="products"></div>
			</div>

			<div class="col-md-6">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-sm" id="tbl_orders" width="100%">
							<thead>
								<td width="60%">Name</td>
								<td width="20%">Qty/Hrs</td>
								<td width="15%">Amount</td>
								<td width="5%"></td>
							</thead>
							<tbody id="tbl_orders_body"></tbody>
						</table>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<table class="table table-sm" id="tbl_subs" width="100%">
							<thead>
								<td width="70%">Sub Total</td>
								<td width="30%" id="sub_total"></td>
							</thead>
						</table>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<table class="table table-sm" id="tbl_discountView" width="100%">
							<thead>
								<td width="70%">Discount</td>
								<td width="30%"></td>
							</thead>
							<tbody id="tbl_discountView_body"></tbody>
						</table>
					</div>
				</div>
				
			</div>
		</div>
	</div>

	<footer>
		<div class="row no-gutters" id="control"></div>
	</footer>

	@include('modals.pos_control')
    
@endsection

@push('scripts')
	<script type="text/javascript">
		var token = $('meta[name="csrf-token"]').attr('content');
	</script>
	<script type="text/javascript" src="{{ asset('/js/pages/pos_control.js') }}"></script>
@endpush
