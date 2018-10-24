@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">New Membership</div>

        <form action="membership/save" method="post" class="form-horizontal" id="frm_membership">
            <div class="card-body">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="id" id="id">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">First Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="firstname" class="form-control form-control-sm clear validate" id="firstname">
                                    <div id="firstname_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Last Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="lastname" class="form-control form-control-sm clear validate" id="lastname">
                                    <div id="lastname_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Email Address</label>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="form-control form-control-sm clear validate" id="email">
                                    <div id="email_feedback"></div>
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

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Phone</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="phone" id="phone">
                                    <div id="phone_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Mobile</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="mobile" id="mobile">
                                    <div id="mobile_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Facebook</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="facebook" id="facebook">
                                    <div id="facebook_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Instagram</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="instagram" id="instagram">
                                    <div id="instagram_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Twitter</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="twitter" id="twitter">
                                    <div id="twitter_feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Occupation</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="occupation" id="occupation">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Company</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="company" id="company">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">School</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="school" id="school">
                                </div>
                            </div>

                            <hr class="dashed">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Membership</label>
                                <div class="col-md-8">
                                    <div class="custom-control custom-radio radio-primary custom-control-inline">
                                        <input type="radio" id="level_a" name="membership_type" value="A" class="custom-control-input">
                                        <label class="custom-control-label" for="level_a">Level A</label>
                                    </div>
                                    <div class="custom-control custom-radio radio-primary custom-control-inline">
                                        <input type="radio" id="level_b" name="membership_type" value="B" class="custom-control-input">
                                        <label class="custom-control-label" for="level_b">Level B</label>
                                    </div>
                                </div>
                            </div>

                            @if (Auth::user()->user_type == "Administrator" || Auth::user()->user_type == "Owner")
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Disable</label>
                                    <div class="col-md-8">
                                        <input class="tgl tgl-light tgl-primary" id="disable" name="disable" type="checkbox">
                                        <label class="tgl-btn" for="disable"></label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="card-footer bg-light">
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="offset-sm-5 col-md-6">
                                    <button class="btn btn-info btn-rounded">Apply</button>
                                    <button class="btn btn-secondary clear-form btn-rounded btn-outline">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/customer/membership.js') }}"></script>
@endpush
