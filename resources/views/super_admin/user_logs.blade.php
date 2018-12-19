@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <span class="trn">User Logs</span>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-sm" id="tbl_logs">
                    <thead>
                        <tr>
                            <th scope="col" class="trn"></th>
                            <th scope="col" class="trn">Module</th>
                            <th scope="col" class="trn">Action Committed</th>
                            <th scope="col" class="trn">Name</th>
                            <th scope="col" class="trn">Date</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_logs_body"></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/super_admin/user_logs.js') }}"></script>
@endpush
