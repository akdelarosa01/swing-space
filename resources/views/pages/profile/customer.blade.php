@extends('layouts.app')

@section('content')
	<div class="card">
		<div class="card-body">
			<div class="row justify-content-center">
				<div class="col-md-2">
					<img src="{{ asset('img/default-profile.png') }}" alt="Profile Photo" class="img-fluid mb-1">
					<div class="custom-file mb-1">
                		<input type="file" class="custom-file-input" id="photo">
                		<label class="custom-file-label trn" for="photo">Choose Photo</label>
					</div>
					<button class="btn btn-primary btn-block mb-3">
						<span class="trn">Upload</span>
					</button>
					<div class="row justify-content-center">
						<div class="col-md-12">
							<img src="{{ asset('img/qr_code.png') }}" alt="QR Code" class="img-fluid mb-1" id="qr_code">
						</div>
					</div>
					
					<h3 class="text-center" id="cust_code"></h3>
				</div>
				<div class="col-md-10">
					<div class="row">
						<div class="col-md-6">
							<table class="table table-sm">
								<tbody>
									<tr>
										<th width="50%" class="border-none trn">First Name</th>
										<td class="border-none">{{ Auth::user()->firstname }}</td>
									</tr>
									<tr>
										<th width="50%" class="border-none trn">Last Name</th>
										<td class="border-none">{{ Auth::user()->lastname }}</td>
									</tr>
									<tr>
										<th width="50%" class="border-none trn">Email Address</th>
										<td class="border-none">{{ Auth::user()->email }}</td>
									</tr>
									<tr>
										<th width="50%" class="border-none trn">Date of Birth</th>
										<td class="border-none">{{ $cust->date_of_birth }}</td>
									</tr>
									<tr>
										<th width="50%" class="border-none trn">Mobile</th>
										<td class="border-none">{{ $cust->mobile }}</td>
									</tr>
								</tbody>
							</table>
        				</div>

        				<div class="col-md-6">
        					<table class="table table-sm">
								<tbody>
									<tr>
										<th width="50%" class="border-none trn">Facebook</th>
										<td class="border-none">{{ $cust->facebook }}</td>
									</tr>
									<tr>
										<th width="50%" class="border-none trn">Instagram</th>
										<td class="border-none">{{ $cust->instagram }}</td>
									</tr>
									<tr>
										<th width="50%" class="border-none trn">Twitter</th>
										<td class="border-none">{{ $cust->twitter }}</td>
									</tr>
									<tr>
										<th width="50%" class="border-none trn">Membership Date</th>
										<td class="border-none">{{ $cust->date_registered }}</td>
									</tr>
								</tbody>
							</table>
        				</div>
					</div>

					<div class="row">
        				<div class="col-md-12">
        					<h4 class="trn">Purchase History</h4>
        					<div class="table-responsive">
        						<table class="table table-striped table-sm" id="tbl_history">
        							<thead>
    									<th class="trn">Product Code</th>
    									<th class="trn">Product Name</th>
    									<th class="trn">Variant</th>
    									<th class="trn">Quantity</th>
    									<th class="trn">Price</th>
    									<th class="trn">Date</th>
        							</thead>
        						</table>
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
    <script type="text/javascript" src="{{ asset('/js/pages/profile/customer.js') }}"></script>
@endpush
