@extends('layouts.app')

@section('content')
    <div class="card">
        <h5 class="card-header">User Master</h5>
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <form method="post" id="frm_users" action="../../admin/user-master/save">
                        @csrf
                        <input type="hidden" id="id" name="id" class="clear">

                        <div class="form-group row">
                            <label for="id_number" class="col-sm-3 col-form-label">ID Number</label>
                            <div class="col-sm-9">
                                <input type="text" id="id_number" name="id_number" class="form-control form-control-sm clear validate">
                                <div id="id_number_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="firstname" name="firstname" class="form-control form-control-sm clear validate">
                                <div id="firstname_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lastname" class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-9">
                                <input type="text" id="lastname" name="lastname" class="form-control form-control-sm clear validate">
                                <div id="lastname_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-3">Gender</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm clear select-validate" name="gender" id="gender">
                                    <option value=""></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <div id="gender_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-sm-3">Birth</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control clear form-control-sm" id="date_of_birth" name="date_of_birth" maxlength="10">
                                <div id="date_of_birth_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="user_type" class="col-sm-3 col-form-label">User Type</label>
                            <div class="col-sm-9">
                                <select class="form-control form-control-sm clear select-validate" name="user_type" id="user_type">
                                    <option value=""></option>
                                    <option value="Owner">Owner</option>
                                    <option value="Employee">Employee</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Administrator">Administrator</option>
                                </select>
                                <div id="user_type_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" id="email" name="email" class="form-control form-control-sm clear validate">
                                <div id="email_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" id="password" name="password" class="form-control form-control-sm clear validate">
                                <div id="password_feedback"></div>
                            </div>
                        </div>
                        <div class="form-group form-check row">
                            <div class="offset-sm-3 col-sm-9">
                                <input type="checkbox" class="form-check-input" name="disable" id="disable">
                                <label class="form-check-label" for="disable">Disable</label>
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

                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped" id="tbl_users" width="100%">
                            <thead>
                                <th width="5%">
                                    <input type="checkbox" class="check_all_users">
                                </th>
                                <th width="10%">ID Number</th>
                                <th width="10%">User type</th>
                                <th width="15%">First Name</th>
                                <th width="20%">Last Name</th>
                                <th width="10%">Email</th>
                                <th width="15%">Password</th>
                                <th width="15%"></th>
                            </thead>
                            <tbody id="tbl_users_body"></tbody>
                        </table>
                    </div>
                    
                </div>
            </div>

            <div class="row">
                <div class="offset-md-10 col-md-2">
                    <button class="btn btn-sm btn-block btn-danger" id="btn_delete">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </div>
            </div>

        </div>
    </div>
    @include('modals.user_master')
    @include('modals.global')
@endsection
@push('scripts')
    <script type="text/javascript">
        let token = $('meta[name=csrf-token]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/super_admin/user_master.js') }}"></script>
@endpush