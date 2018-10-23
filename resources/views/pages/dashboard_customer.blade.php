@extends('layouts.app')

@section('content')
    <div class="row">
    	<div class="col-md-3">
    		<div class="card">
    			<div class="card-body">
    				<div class="row justify-content-center">
						<img src="{{ asset('img/qr_code.png') }}" alt="QR Code" class="img-fluid mb-1">
					</div>
					
					<p class="text-center">CS10001</p>
    			</div>
    		</div>

    		<div class="card">
    			<div class="card-header">Available Refund Points</div>
    			<div class="card-body">
    				<div class="row justify-content-center">
						<h3>340 Points</h3>
					</div>
    			</div>
    		</div>

    		<div class="card">
    			<div class="card-header">Time spent today</div>
    			<div class="card-body">
    				<div class="row justify-content-center">
						<h3>02:34:49</h3>
					</div>
    			</div>
    		</div>
    		
    	</div>

        <div class="col-md-3">
			<div class="card contact-item">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 text-center">
							<img src="{{ asset('img/default-profile.png') }}" alt="user" class="rounded-circle max-w-100 m-t-20">
						</div>
						<div class="col-md-12 text-center">
							<h5 class="card-title">Dren Bayani

								</h5>
							<small class="text-muted d-block">Guest</small>
							<small class="text-muted d-block">
								dren.bayani@gmail.com
							</small>
						</div>
					</div>
				</div>
			</div>

			<div class="card contact-item">
				<div class="card-body">
					<div class="row">
						<div class="col-md-12 text-center">
							<img src="{{ asset('img/default-profile.png') }}" alt="user" class="rounded-circle max-w-100 m-t-20">
						</div>
						<div class="col-md-12 text-center">
							<h5 class="card-title">Renier Ordiz

								</h5>
							<small class="text-muted d-block">Guest</small>
							<small class="text-muted d-block">
								renier.ordiz@gmail.com
							</small>
						</div>
					</div>
				</div>
			</div>

        </div>

        <div class="col-md-6">
        	<div class="card">
        		<div class="card-header">Your Bill for Today</div>
        		<div class="card-body">
        			<div class="table-responsive">
        				<table class="table">
        					<tbody>
	    						<tr>
	    							<td class="border-none">Hours</td>
	    							<td class="border-none text-right">3</td>
	    							<td class="border-none text-right">Php 450</td>
	    						</tr>
	    						<tr>
	    							<td class="border-none">Coffee</td>
	    							<td class="border-none text-right">1</td>
	    							<td class="border-none text-right">Php 70.00</td>
	    						</tr>
	    						<tr>
	    							<td class="border-none"></td>
	    							<td class="border-none"></td>
	    							<td class="border-none text-right">
	    								<h1>Php 5200</h1>
	    							</td>
	    						</tr>
	    					</tbody>
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
@endpush
