@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">New Employee</div>
        <div class="card-body">
        	<div class="row">

        		<div class="col-md-6">
                    <form action="#" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">First Name</label>
                                <div class="col-md-8">
                                    <input type="text" placeholder="Your first name" class="form-control form-control-sm" autocomplete="given-name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Last Name</label>
                                <div class="col-md-8">
                                    <input type="text" placeholder="Your last name" class="form-control form-control-sm" autocomplete="family-name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Email Address</label>
                                <div class="col-md-8">
                                    <input type="text" placeholder="Your email address" class="form-control form-control-sm" autocomplete="email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Date of Birth</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control form-control-sm" placeholder="dd/mm/yyyy">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Position</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm">
                                        <option value="">Select Employee position.</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Phone</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Mobile</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Street</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">State</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm">
                                        <option value="">Please select a province.</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">City</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Zip</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <hr class="dashed">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">TIN #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">SSS #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Philhealth #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">PAG-IBIG #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                	<div class="row justify-content-center mb-5">
                		<div class="col-md-4">
                			<img src="{{ asset('img/default-profile.png') }}" alt="Profile Photo" class="img-fluid">
                		</div>
                	</div>

                	<div class="row justify-content-center mb-5">
                		<div class="col-md-6">
                			<div class="custom-file">
		                		<input type="file" class="custom-file-input" id="photo">
		                		<label class="custom-file-label" for="photo">Choose Photo</label>
							 </div>
                		</div>
                	</div>

                	<hr class="dashed">

                	<div class="row">
                		<div class="col-md-12">
                			<h4>Employee Access</h4>
		                	<div class="table-responsive">
		                		<table class="table table-striped table-sm">
		                			<thead>
		                				<tr>
		                					<th>Page</th>
		                					<th>Read / Write</th>
		                					<th>Read</th>
		                				</tr>
		                			</thead>
		                			<tbody>
		                				<tr>
		                					<td>POS Control</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                				</tr>
		                				<tr>
		                					<td>Customer List</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                				</tr>
		                				<tr>
		                					<td>Customer Membership</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                				</tr>
		                				<tr>
		                					<td>Inventories</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                				</tr>
		                				<tr>
		                					<td>Receive Items</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                				</tr>
		                				<tr>
		                					<td>Sales Report</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                					<td>
		                						<input type="checkbox">
		                					</td>
		                				</tr>
		                			</tbody>
		                		</table>
		                	</div>
                		</div>
                	</div>
                	
                	
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <div class="form-actions">
                <div class="row">
                    <div class="offset-sm-5 col-md-6">
                        <button class="btn btn-info btn-rounded">Save</button>
                        <button class="btn btn-secondary clear-form btn-rounded btn-outline">Cancel</button>
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
