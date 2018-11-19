@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img src="{{ asset(Auth::user()->photo) }}" alt="Profile Photo" class="img-fluid mb-1">
                    <img src="{{ asset('img/qr_code.png') }}" alt="QR Code" class="img-fluid">
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th class="border-none trn">First Name</th>
                                        <td class="border-none">{{ Auth::user()->firstname }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">Last Name</th>
                                        <td class="border-none">{{ Auth::user()->lastname }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">Email Address</th>
                                        <td class="border-none">{{ Auth::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">Date of Birth</th>
                                        <td class="border-none">{{ $emp->date_of_birth }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">Mobile</th>
                                        <td class="border-none">{{ $emp->mobile }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th class="border-none trn">Street</th>
                                        <td class="border-none">{{ $emp->street }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">State</th>
                                        <td class="border-none">{{ $emp->state }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">City</th>
                                        <td class="border-none">{{ $emp->city }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">Zip</th>
                                        <td class="border-none">{{ $emp->zip }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th class="border-none trn">TIN #</th>
                                        <td class="border-none">{{ $emp->tin }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">SSS #</th>
                                        <td class="border-none">{{ $emp->sss }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">PhilHealth #</th>
                                        <td class="border-none">{{ $emp->philhealth }}</td>
                                    </tr>
                                    <tr>
                                        <th class="border-none trn">PAG-IBIG #</th>
                                        <td class="border-none">{{ $emp->pagibig }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4>Page Access</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th class="trn">Page</th>
                                            <th class="trn">Read / Write</th>
                                            <th class="trn">Read</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user_access as $access)
                                            <tr>
                                                <td>{{ $access->module_name }}</td>
                                                <td>
                                                    <input type="checkbox" readonly @if($access->access == 1){{'checked'}}@endif>
                                                </td>
                                                <td>
                                                    <input type="checkbox" readonly @if($access->access == 2){{'checked'}}@endif>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h4>Purchase History</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th class="trn">Product Code</th>
                                            <th class="trn">Product Name</th>
                                            <th class="trn">Product Type</th>
                                            <th class="trn">Price</th>
                                            <th class="trn">Date</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
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
    <script type="text/javascript" src="{{ asset('/js/pages/profile/employee.js') }}"></script>
@endpush
