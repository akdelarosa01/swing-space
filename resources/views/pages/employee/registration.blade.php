@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span data-localize="registration.title">Employee Registration</span>
            <a href="{{ url('/employee-list') }}" class="btn btn-sm btn-info pull-right">Employee List</a>
        </div>
        <form action="../../employee/save" id="frm_registration" enctype="multipart/form-data" method="post">
            @csrf
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-body">
                            <input type="hidden" name="id" id="id" value="@if(isset($id)) {{ $id }} @endif">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">First Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" id="firstname" name="firstname">
                                    <div id="firstname_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Last Name</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" id="lastname" name="lastname">
                                    <div id="lastname_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Gender</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm clear select-validate" name="gender" id="gender">
                                        <option value=""></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div id="gender_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Date of Birth</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control form-control-sm" id="date_of_birth" name="date_of_birth">
                                    <div id="date_of_birth_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Position</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm" id="position" name="position">
                                        <option value="">Select Employee position.</option>
                                    </select>
                                    <div id="position_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed ">

                             <div class="form-group row">
                                <label class="control-label text-right col-md-3">Email Address</label>
                                <div class="col-md-8">
                                    <input type="email" class="form-control form-control-sm" id="email" name="email">
                                    <div id="email_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Password</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control form-control-sm" id="password" name="password">
                                    <div id="password_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Confirm Password</label>
                                <div class="col-md-8">
                                    <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation">
                                    <div id="password_confirmation_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Mobile</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" id="mobile" name="mobile">
                                    <div id="mobile_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Street</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm" id="street" name="street">
                                    <div id="street_feedback"></div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">State</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm" id="state" name="state">
                                        <option value="">Please select a province.</option>
                                    </select>
                                    <div id="state_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">City</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm" id="city" name="city" disabled>
                                        <option value=""></option>
                                    </select>
                                    <div id="city_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Zip</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm" id="zip" name="zip" maxlength="4">
                                    <div id="zip_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">TIN #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm" id="tin" name="tin">
                                    <div id="tin_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">SSS #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm" id="sss" name="sss">
                                    <div id="sss_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Philhealth #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm" id="philhealth" name="philhealth">
                                    <div id="philhealth_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">PAG-IBIG #</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm" id="pagibig" name="pagibig">
                                    <div id="pagibig_feedback"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row justify-content-center mb-5">
                            <div class="col-md-4">
                                <img src="{{ asset('img/default-profile.png') }}" alt="Profile Photo" class="img-fluid photo" height="300px" id="profile_photo">
                            </div>
                        </div>

                        <div class="row justify-content-center mb-5">
                            <div class="col-md-6">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="photo" name="photo">
                                    <label class="custom-file-label" for="photo">Choose Photo</label>
                                 </div>
                            </div>
                        </div>

                        <hr class="dashed">

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Employee Access</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm" id="tbl_modules">
                                        <thead>
                                            <tr>
                                                <th>Page</th>
                                                <th>Read / Write</th>
                                                <th>Read</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_modules_body"></tbody>
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
                            <button type="submit" class="btn btn-info btn-rounded">Save</button>
                            <button class="btn btn-secondary clear-form btn-rounded btn-outline">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
            
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        let token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/employee/registration.js') }}"></script>
@endpush
