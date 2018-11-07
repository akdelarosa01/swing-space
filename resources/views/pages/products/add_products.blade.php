@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Add Product</div>
                <form>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="prod_code">Product Code</label>
                            <input type="text" class="form-control" id="prod_code" readonly>
                        </div>

                        <div class="form-group">
                            <label for="prod_name">Product Name</label>
                            <input type="text" class="form-control" id="prod_name">
                        </div>

                        <div class="form-group">
                            <label for="prod_type">Type</label>
                            <select name="prod_type" class="form-control">
                            	<option value="">Select Product type</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="package">Price</label>
                            <div class="input-group">
                            	<div class="input-group-prepend">
                        			<span class="input-group-text">Php.</span>
                        		</div>
                        		<input type="text" class="form-control" id="price" value="0.00">
                        	</div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description"></textarea>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <button type="button" class="btn btn-sm btn-info">Submit</button>
                        <button type="button" class="btn btn-sm btn-secondary clear-form">Clear</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tbl_products">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Description</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl_products_body"></tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-sm btn-info pull-right">Save</button>
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
    <script type="text/javascript" src="{{ asset('/js/pages/add_products.js') }}"></script>
@endpush
