@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tbl_dropdown">
                            <thead>
                                <tr>
                                    <th scope="col">Dropdowns</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl_dropdown_body">
                                <tr>
                                    <td width="90%">Employee Position</td>
                                    <td width="10%">
                                        <button class="btn btn-sm btn-info">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="90%">Product Type</td>
                                    <td width="10%">
                                        <button class="btn btn-sm btn-info">Edit</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="90%">Item Package</td>
                                    <td width="10%">
                                        <button class="btn btn-sm btn-info">Edit</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Dropdown Options</div>
                <form>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="item_code">Item Code</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm" id="item_code"readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-sm btn-info" id="btn_add">
                                        Add
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm" id="tbl_dropdown">
                                <thead>
                                    <tr>
                                        <th scope="col">Options</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_dropdown_body">
                                    <tr>
                                        <td class="text-center" colspan="2">No data displayed.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <button type="button" class="btn btn-sm btn-info">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary clear-form">Clear</button>
                    </div>
                </form>
            </div>
        </div>

        
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
@endpush
