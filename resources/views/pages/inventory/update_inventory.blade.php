@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Update Inventory
        </div>
        <div class="card-body">
            <form class="form-inline">
                <div class="form-group mb-2">
                    <label for="item_type" class="mr-2">Item Type:</label>
                    <input type="text" class="form-control form-control-sm" id="item_type">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="from" class="mr-2">From: </label>
                    <input type="date" class="form-control form-control-sm" id="from" placeholder="From">
                    
                </div>

                <div class="form-group mx-sm-3 mb-2">
                    <label for="from" class="mr-2">To: </label>
                    <input type="date" class="form-control form-control-sm" id="to" placeholder="To">
                </div>
                <button type="submit" class="btn btn-info btn-sm mb-2">Search</button>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Qty. Received</th>
                                <th>Actual Qty.</th>
                                <th></th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">No data displayed.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="offset-md-4 col-md-1">
                    <button type="button" class="btn btn-success btn-sm btn-block" id="btn_new">New</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-info btn-sm btn-block" id="btn_edit">Edit</button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm btn-block" id="btn_cancel">Cancel</button>
                </div>
            </div>

        </div>
    </div>

@include('partials.modal_update_inventory')

@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/update_inventory.js') }}"></script>
@endpush
