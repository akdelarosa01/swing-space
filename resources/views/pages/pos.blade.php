@extends('layouts.app')

@section('content')
    <div class="row no-gutters" id="product_types"></div>
    <hr/>

	<div class="row">
		<div class="col-md-7">
			<div class="row no-gutters" id="products"></div>
		</div>

		<div class="col-md-5">
			<table class="table table-sm" id="tbl_orders">
				<thead>
					<td width="60%">Name</td>
					<td width="20%">Qty</td>
					<td width="15%">Price</td>
					<td width="5%"></td>
				</thead>
				<tbody id="tbl_orders_body"></tbody>
			</table>
		</div>
	</div>
    
@endsection

@push('scripts')
	<script type="text/javascript">
		var token = $('meta[name="csrf-token"]').attr('content');
	</script>
	<script type="text/javascript" src="{{ asset('/js/pages/pos_control.js') }}"></script>
@endpush
