@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-10 col-xs-12">
            <div class="card">
                <div class="card-header" data-localize="gen_set.title">General Settings</div>
                <div class="card-body">
                    <form action="#" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Start up Points</label>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                		<input type="text" class="form-control form-control-sm" value="0">
                                		<div class="input-group-append">
                                			<span class="input-group-text">Pts.</span>
                                		</div>
                                	</div>
                                    <small class="form-text text-muted">Head start points for membered customer</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Points per Invite</label>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                		<input type="text" class="form-control form-control-sm" value="0">
                                		<div class="input-group-append">
                                			<span class="input-group-text">Pts.</span>
                                		</div>
                                	</div>
                                    <small class="form-text text-muted">Points when customer has 1 invited guest</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Points for every purchase</label>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                		<input type="text" class="form-control form-control-sm" value="0">
                                		<div class="input-group-append">
                                			<span class="input-group-text">Pts.</span>
                                		</div>
                                	</div>
                                    <small class="form-text text-muted">Points acquired when purchasing</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Points for member for every guest purchase</label>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                		<input type="text" class="form-control form-control-sm" value="0">
                                		<div class="input-group-append">
                                			<span class="input-group-text">Pts.</span>
                                		</div>
                                	</div>
                                    <small class="form-text text-muted">Points acquired when membered customer's guest is purchasing</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Points for every guest purchase</label>
                                <div class="col-md-6">
                                    <div class="input-group input-group-sm">
                                		<input type="text" class="form-control form-control-sm" value="0">
                                		<div class="input-group-append">
                                			<span class="input-group-text">Pts.</span>
                                		</div>
                                	</div>
                                    <small class="form-text text-muted">Points acquired when guest is purchasing</small>
                                </div>
                            </div>

                            <hr class="dashed ">

                            <div class="form-group row">
                                <label class="control-label text-right col-md-5">Employee discount</label>
                                <div class="col-md-6">
                                	<div class="input-group input-group-sm">
                                		<input type="text" class="form-control form-control-sm" value="0">
                                		<div class="input-group-append">
                                			<span class="input-group-text">%</span>
                                		</div>
                                	</div>
                                    <small class="form-text text-muted">Points acquired when guest is purchasing</small>
                                </div>
                            </div>

                            
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light">
                    <div class="form-actions">
                        <div class="row">
                            <div class="offset-sm-5 col-md-6">
                                <button class="btn btn-sm btn-info btn-rounded">Apply</button>
                                <button class="btn btn-sm btn-secondary clear-form btn-rounded btn-outline">Cancel</button>
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
@endpush
