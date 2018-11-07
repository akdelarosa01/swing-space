@extends('layouts.app')

@section('content')
    <div class="row">
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
                                <i class="icon dripicons-user-group"></i>
                            </div>
                            <h5 class="card-title m-b-5 counter" data-count="40">4</h5>
                            <h6 class="text-muted m-t-10">
                                Total employees
                            </h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">Sales</h5>
                <div class="card-body p-10">
                      <h5 class="card-title secondary-type m-b-0 m-l-10">Php 43,000</h5>
                        <small class="text-muted m-l-10">Week of Oct. 1st - Oct. 5th</small>
                    <div id="ct-LineChart1" class="chartist-primary">
                        <div class="ct-chart"></div>
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
