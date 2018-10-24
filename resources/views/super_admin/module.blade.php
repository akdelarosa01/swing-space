@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">Modules</h5>
        <div class="card-body">

            <div class="row">
                <div class="col-md-5">
                    <form method="post" id="frm_module" action="/admin/module/save">
                        @csrf
                        <input type="hidden" id="id" name="id" class="clear">

                        <div class="form-group row">
                            <label for="module_code" class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-10">
                                <input type="text" id="module_code" name="module_code" class="form-control form-control-sm clear validate">
                                <div id="module_code_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="module_name" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" id="module_name" name="module_name" class="form-control form-control-sm clear validate">
                                <div id="module_name_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="module_category" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <input type="text" id="module_category" name="module_category" class="form-control form-control-sm clear validate">
                                <div id="module_category_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                            <div class="col-sm-10">
                                <input type="text" id="icon" name="icon" class="form-control form-control-sm clear validate">
                                <div id="icon_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-danger btn-sm pull-left" id="btn_cancel">Cancel</button>
                                <button type="submit" class="btn btn-info btn-sm pull-right" >Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-7">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped" id="tbl_modules" width="100%">
                            <thead>
                                <th width="15%">Code</th>
                                <th width="55%">Name</th>
                                <th width="20%">Category</th>
                                <th width="5%">Icon</th>
                                <th width="5%"></th>
                            </thead>
                            <tbody id="tbl_modules_body"></tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript">
        let token = $('meta[name=csrf-token]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/super_admin/module.js') }}"></script>
@endpush