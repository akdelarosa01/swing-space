@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="loading"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    @if(Auth::user()->user_type == 'Administrator')
                    <form action="../../dropdown/save-name" id="frm_name" method="post">
                        @csrf
                        <input type="hidden" id="id" name="id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text trn">Dropdown Name</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm clear validate" id="description" name="description">
                                    <div id="description_feedback"></div>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-sm btn-info btn-permission" id="btn_add_name">
                                            <span class="trn">Save</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                        
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tbl_name" width="100%">
                            <thead>
                                <tr>
                                    {{-- <th width="5%">
                                        <input type="checkbox" class="check_all_name">
                                    </th> --}}
                                    <th width="80%" class="trn">Dropdowns</th>
                                    <th width="20%"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl_name_body"></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header" >
                    <span id="dropdown_name">Dropdown</span> <span class="trn">Option</span>
                </div>
                <div class="card-body">
                    <form method="post" action="../../dropdown/save-option" id="frm_options">
                        @csrf
                        <input type="hidden" id="dropdown_id" name="dropdown_id">
                        <input type="hidden" id="option_id" name="option_id">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text trn">Option</span>
                                    </div>
                                    <input type="text" class="form-control form-control-sm clear validate" id="option_description" name="option_description" readonly>
                                    <div id="option_description_feedback"></div>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-sm btn-info btn-permission">
                                            <span class="trn">Save</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    

                    <div class="table-responsive">
                        <table class="table table-striped table-sm" id="tbl_option">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <input type="checkbox" class="check_all_options" width="100%">
                                    </th>
                                    <th width="85%" class="trn">Option</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody id="tbl_option_body"></tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="offset-md-10 col-md-2">
                            <button type="button" class="btn btn-sm btn-block btn-danger btn-permission" id="btn_delete">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        let token = $('meta[name="csrf-token"]').attr('content');
        let user_type = "{{ Auth::user()->user_type }}";
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/settings/dropdown.js') }}"></script>
@endpush
