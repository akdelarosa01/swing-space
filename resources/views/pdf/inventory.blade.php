@extends('pdf.layout')

@section('content')
	<div class="container">

		<div class="row">
			<div class="col-xs-12">
				<table class="fontArial" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
			        <tbody>
			            <tr>
			                <td align="center">
				                <img src="{{ asset('/img/logo.png') }}" alt="" height="150px" height="200px" style="margin-bottom:20px">
				                <p style="line-height: 1.8px; font-size:12px; ">Unit 2 Mezzanine, Burgundy Place, B. Gonzales St.,</p>
				            	<p style="line-height: 1.8px; font-size:12px; ">Loyola Heights Katipunan, Quezon City</p>
				                <p style="line-height: 1.8px; font-size:12px; ">{{ 'spacekatipunan@gmail.com' }}</p>
				                <h3><ins>INVENTORY LIST</ins></h3>
			                </td>
			            </tr>
			        </tbody>
			    </table>
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-xs-12">
				<table class="table table-condensed table-stripped table-bordered" width="100%">
					<thead>
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Item Type</th>
						<th>Quantity</th>
						<th>Minimum Stock</th>
					</thead>
					<tbody>
						<?php
							foreach($data as $key => $dt) {
						?>
								<tr>
									<td>{{ $dt->item_code }}</td>
									<td>{{ $dt->item_name }}</td>
									<td>{{ $dt->item_type }}</td>
									<td>{{ $dt->quantity }}</td>
									<td>{{ $dt->minimum_stock }}</td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div>
		</div>



		
	</div>
	
@endsection