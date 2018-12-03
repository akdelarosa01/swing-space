@extends('layouts.app')

@section('content')

	<div id="customers">
		<div class="row no-gutters">
			<div class="col-md-2 ml-1 mb-1">
				<button type="button" class="btn btn-lg btn-block btn-success btn-outline" id="btn_walkin">
					<span class="trn" style="font-size:12px;word-wrap: break-word;">Walk-in</span>
				</button>
			</div>
			<div class="col-md-2 ml-1 mb-1">
				<button type="button" class="btn btn-lg btn-block btn-info btn-outline" id="btn_member">
					<span class="trn" style="font-size:12px;word-wrap: break-word;">Members</span>
				</button>
			</div>

			<div class="col-md-2 ml-1 mb-1">
				<button type="button" class="btn btn-lg btn-block btn-accent" id="btn_open">
					<span class="trn" style="font-size:12px;word-wrap: break-word;">Open Customer's View</span>
				</button>
			</div>
		</div>

		<div class="row no-gutters" id="current_customers"></div>
	</div>

	<div id="pos_control">
		<div class="row">
			<div class="col-md-8">
				<div class="row no-gutters" id="product_types"></div>
				<hr/>
				<div class="row no-gutters" id="products"></div>
			</div>

			<div class="col-md-4">
				<table class="table table-sm" id="tbl_orders" width="100%">
					<thead>
						<td width="55%" class="trn">Name</td>
						<td width="20%" class="trn">Qty/Hrs</td>
						<td width="15%" class="trn">Price</td>
						<td width="5%"></td>
					</thead>
					<tbody id="tbl_orders_body"></tbody>
				</table>
				<table class="table table-sm" id="tbl_subs" width="100%">
					<thead>
						<td width="70%" class="trn">Sub Total</td>
						<td width="30%" id="sub_total"></td>
					</thead>
				</table>
				<table class="table table-sm" id="tbl_discountView" width="100%">
					<thead>
						<td width="70%" class="trn">Discount</td>
						<td width="30%"></td>
					</thead>
					<tbody id="tbl_discountView_body"></tbody>
				</table>
				<table class="table table-sm" id="tbl_rewardView" width="100%">
					<thead>
						<td width="70%" class="trn">Rewards</td>
						<td width="30%"></td>
					</thead>
					<tbody id="tbl_rewardView_body"></tbody>
				</table>
				
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
