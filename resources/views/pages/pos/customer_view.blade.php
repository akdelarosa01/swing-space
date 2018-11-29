<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Swing Space') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

    @stack('styles')
    <link rel="stylesheet" href="{{ mix('/css/main.css') }}">
</head>
<body class="compact-menu">
    <div id="vue_app">
        <div id="app">
            <section class="page-content container-fluid">
                <div class="loading"></div>
                {{-- <div id="pos_control"> --}}

					<div class="row">
						<div class="col-md-7">
							<img src="/img/logo.png" alt="" class="img-fluid" height="300px">
						</div>

						<div class="col-md-5">
							<div class="card mt-10">
								<div class="card-body">

									<div class="row">
										<div class="col-md-12">
											<table class="table table-sm" id="tbl_custview" width="100%">
												<thead>
													<td width="60%">Name</td>
													<td width="20%">Qty/Hrs</td>
													<td width="20%">Amount</td>
												</thead>
												<tbody id="tbl_custview_body"></tbody>
											</table>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<table class="table table-sm" id="tbl_subs" width="100%">
												<thead>
													<td width="70%">Sub Total</td>
													<td width="30%"></td>
												</thead>
												<tbody id="tbl_subs_body"></tbody>
											</table>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				{{-- </div> --}}
            </section>
        </div>
    </div>

    <script src="{{ mix('/js/main.js') }}"></script>
    <script type="text/javascript">
		var token = $('meta[name="csrf-token"]').attr('content');
	</script>
	<script type="text/javascript" src="{{ asset('/js/pages/pos_control.js') }}"></script>
    <script type="text/javascript">
        getLanguage();
    </script>
</body>
</html>