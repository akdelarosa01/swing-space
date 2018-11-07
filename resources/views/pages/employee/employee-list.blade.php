@extends('layouts.app')

@section('content')
    <div class="row" id="employee_list"></div>
@endsection

@push('scripts')
    <script type="text/javascript">
        let token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/employee/employee_list.js') }}"></script>
@endpush
