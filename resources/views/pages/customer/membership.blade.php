@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            Membership
            <a href="{{ url('/customer-list') }}" class="btn btn-sm btn-danger pull-right">Back</a>
        </div>

        <form action="../../membership/save" method="post" class="form-horizontal" id="frm_membership">
            <div class="card-body">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="id" id="id" value="@if(isset($id)) {{ $id }} @endif">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">First Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="firstname" class="form-control form-control-sm clear validate" id="firstname" value="@if(isset($c->firstname)) {{ $c->firstname }} @endif">
                                    <div id="firstname_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Last Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="lastname" class="form-control form-control-sm clear validate" id="lastname" value="@if(isset($c->lastname)) {{ $c->lastname }} @endif">
                                    <div id="lastname_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Email Address</label>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="form-control form-control-sm clear validate" id="email" value="@if(isset($c->email)) {{ $c->email }} @endif">
                                    <div id="email_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Gender</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm clear select-validate" name="gender" id="gender">
                                        <option value=""></option>
                                        <option value="Male" @if(isset($c->gender) && $c->gender == 'Male') {{ 'selected' }} @endif>Male</option>
                                        <option value="Female" @if(isset($c->gender) && $c->gender == 'Female') {{ 'selected' }} @endif>Female</option>
                                    </select>
                                    <div id="gender_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Date of Birth</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control form-control-sm clear" id="date_of_birth" name="date_of_birth">
                                    <div id="date_of_birth_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Phone</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="phone" id="phone" value="@if(isset($c->phone)) {{ $c->phone }} @endif">
                                    <div id="phone_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Mobile</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="mobile" id="mobile" value="@if(isset($c->mobile)) {{ $c->mobile }} @endif">
                                    <div id="mobile_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Facebook</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="facebook" id="facebook" value="@if(isset($c->facebook)) {{ $c->facebook }} @endif">
                                    <div id="facebook_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Instagram</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="instagram" id="instagram" value="@if(isset($c->instagram)) {{ $c->instagram }} @endif">
                                    <div id="instagram_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Twitter</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="twitter" id="twitter" value="@if(isset($c->twitter)) {{ $c->twitter }} @endif">
                                    <div id="twitter_feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Occupation</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="occupation" id="occupation" value="@if(isset($c->occupation)) {{ $c->occupation }} @endif">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Company</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="company" id="company" value="@if(isset($c->company)) {{ $c->phone }} @endif">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">School</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="school" id="school" value="@if(isset($c->school)) {{ $c->school }} @endif">
                                </div>
                            </div>

                            <hr class="dashed">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Referrer</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm clear select-validate select2" name="referrer" id="referrer"></select>
                                    <div id="referrer_feedback"></div>
                                </div>
                            </div>

                            @if (Auth::user()->user_type == "Administrator" || Auth::user()->user_type == "Owner")
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3">Disable</label>
                                    <div class="col-md-8">
                                        <input class="tgl tgl-light tgl-primary" id="disable" @if(isset($c->disable) && $c->disable == 1) {{ 'checked' }}@endif name="disable" type="checkbox">
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
                                    <button type="submit" class="btn btn-info btn-rounded">Apply</button>
                                    <button type="button" class="btn btn-secondary clear-form btn-rounded btn-outline">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @include('modals.membership')
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/customer/membership.js') }}"></script>
@endpush
