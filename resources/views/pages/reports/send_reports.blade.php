@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class="trn">Send Reports</span>
                </div>
                <div class="card-body">
                    <form action="../../send-reports/save" id="frm_reports" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="email_to" class="control-label text-right col-md-3 trn">To</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control form-control-sm clear validate" id="email_to" name="email_to">
                                <div id="email_to_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email_subject" class="control-label text-right col-md-3 trn">Subject</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control form-control-sm clear validate" id="email_subject" name="email_subject">
                                <div id="email_subject_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email_msg" class="control-label text-right col-md-3 trn">Message</label>
                            <div class="col-md-9">
                                <textarea class="form-control form-control-sm clear validate" id="email_msg" name="email_msg"></textarea>
                                <div id="email_msg_feedback"></div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prod_name" class="control-label text-right col-md-3 trn">File</label>
                            <div class="col-md-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="attachment" name="attachment[]" multiple>
                                    <label class="custom-file-label trn" for="attachment">Choose xlxs file</label>
                                 </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="offset-md-10 col-md-2">
                                <button type="submit" class="btn btn-sm btn-success btn-block btn-permission">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
            
@endsection

@push('scripts')
    <script type="text/javascript">
        var token = $('meta[name="csrf-token"]').attr('content');
    </script>
    <script type="text/javascript" src="{{ asset('/js/pages/reports/send_reports.js') }}"></script>
@endpush
