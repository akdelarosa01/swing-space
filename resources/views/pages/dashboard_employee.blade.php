@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Customers Today</h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm v-align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th class="p-l-20">Name</th>
                                    <th>Time Spent</th>
                                    <th>Total Bill</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Robert Norris</strong>
                                    </td>
                                    <td>01:20:00</td>
                                    <td>Php 250.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Shawna Cohen</strong>
                                    </td>
                                    <td>01:22:03</td>
                                    <td>Php 560.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Darrin Todd</strong>
                                    </td>
                                    <td>00:08:50</td>
                                    <td>Php 100.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Michelle White</strong>
                                    </td>
                                    <td>01:16:00</td>
                                    <td>Php 250.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Josh Lynch</strong>
                                    </td>
                                    <td>01:40:00</td>
                                    <td>Php 360.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Jason Kendall</strong>
                                    </td>
                                    <td>01:00:58</td>
                                    <td>Php 340.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Aaron Elliott</strong>
                                    </td>
                                    <td>02:20:00</td>
                                    <td>Php 800.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <img class="align-self-center mr-3 ml-2 w-50 rounded-circle" src="{{ asset('/img/default-profile.png') }}" alt="">
                                        <strong class="nowrap">Rebecca Harris</strong>
                                    </td>
                                    <td>03:23:00</td>
                                    <td>Php 600.00</td>
                                    <td>
                                        <a href="{{ url('employee/checkout') }}" class="btn btn-success btn-sm btn-outline">Checkout</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-rounded icon-rounded-primary float-left m-r-20">
                                <i class="icon dripicons-user-group"></i>
                            </div>
                            <h5 class="card-title m-b-5 counter" data-count="150">150</h5>
                            <h6 class="text-muted m-t-10">
                                Total membered customers
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="icon-rounded icon-rounded-accent float-left m-r-20">
                                <i class="icon dripicons-shopping-bag"></i>
                            </div>
                            <h5 class="card-title m-b-5 counter" data-count="40">40</h5>
                            <h6 class="text-muted m-t-10">
                                Total sold products today
                            </h6>
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
@endpush
