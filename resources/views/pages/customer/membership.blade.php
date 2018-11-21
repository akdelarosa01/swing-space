@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="trn">Membership</span>
            <a href="{{ url('/customer-list') }}" class="btn btn-sm btn-info btn-rounded btn-outline pull-right">
                <span class="trn">Customer List</span>
            </a>
        </div>

        <form action="../../membership/save" method="post" class="form-horizontal" id="frm_membership">
            <div class="card-body">
                @csrf
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="id" id="id" value="@if(isset($id)) {{ $id }} @endif">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">First Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="firstname" class="form-control form-control-sm clear validate" id="firstname">
                                    <div id="firstname_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Last Name</label>
                                <div class="col-md-8">
                                    <input type="text" name="lastname" class="form-control form-control-sm clear validate" id="lastname">
                                    <div id="lastname_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Email Address</label>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="form-control form-control-sm clear validate" id="email">
                                    <div id="email_feedback"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Gender</label>
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
                                <label class="control-label text-right col-md-3 trn">Date of Birth</label>
                                <div class="col-md-8">
                                    <input type="date" class="form-control form-control-sm clear" id="date_of_birth" name="date_of_birth" maxlength="10">
                                    <div id="date_of_birth_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed ">

                            {{-- <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">@lang('membership.phone')</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="phone" id="phone">
                                    <div id="phone_feedback"></div>
                                </div>
                            </div> --}}

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Mobile</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="mobile" id="mobile">
                                    <div id="mobile_feedback"></div>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Facebook</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="facebook" id="facebook">
                                    <div id="facebook_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Instagram</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="instagram" id="instagram">
                                    <div id="instagram_feedback"></div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Twitter</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="twitter" id="twitter">
                                    <div id="twitter_feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Occupation</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="occupation" id="occupation">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Company</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="company" id="company">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">School</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm clear validate" name="school" id="school">
                                </div>
                            </div>

                            <hr class="dashed">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-3 trn">Referrer</label>
                                <div class="col-md-8">
                                    <select class="form-control form-control-sm clear select-validate" name="referrer" id="referrer">
                                    </select>
                                    <div id="referrer_feedback"></div>
                                </div>
                            </div>

                            @if (Auth::user()->user_type == "Administrator" || Auth::user()->user_type == "Owner")
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-3 trn">Disable</label>
                                    <div class="col-md-8">
                                        <input class="tgl tgl-light tgl-primary" id="disabled" name="disabled" type="checkbox">
                                        <label class="tgl-btn" for="disabled"></label>
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
                                    <button type="submit" class="btn btn-info btn-rounded">
                                        <span class="trn">Apply</span>
                                    </button>
                                    <button type="button" class="btn btn-secondary clear-form btn-rounded btn-outline">
                                        <span class="trn">Cancel</span>
                                    </button>
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
