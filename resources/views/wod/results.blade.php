<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<title>Results</title>
</head>
<body>

	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="w-100 text-right p-3"><button class="btn btn-info text-right">Back</button></div>

			<ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">

				<?php

					$active = '';
					foreach ($data['tabs'] as $key => $value) {

						if ( $key == 0 ) {
							$active = 'active';
						} else {
							$active = '';
						}
						echo '<li class="nav-item"><a class="nav-link '.$active.'" id="'.$value->settingdesc.'-tab-md" data-toggle="tab" href="#'.$value->settingdesc.'-md" role="tab" aria-controls="'.$value->settingdesc.'-md" aria-selected="true">'.$value->settingdesc.'</a></li>';

					}
			
				?>

			</ul>
			
			<div class="tab-content card pt-5" id="myTabContentMD">

				<?php
					foreach ($data['tabs'] as $key => $value) {

						if ( $key == 0 ) {
							$active = 'active';
						} else {
							$active = '';
						}

						echo '<div class="tab-pane fade show '.$active.'" id="'.$value->settingdesc.'-md" role="tabpanel" aria-labelledby="'.$value->settingdesc.'-tab-md">';
						echo '<p class="p-3">';

						?>

						Lumen is the perfect solution for building Laravel based micro-services and blazing fast APIs. In fact, it's one of the fastest micro-frameworks available. It has never been easier to write stunningly fast services to support your Laravel applications.<br /><br /><br />

						<div style="border: 0px solid black; padding: 10px;">
							<table class="table table-hover table-condensed" style="" id="invoices-table">
								<thead>
									<th style="width: 50%">Athlete</th>
									<th style="width: 50%">Time/Reps</th>
								</thead>
								<tbody id='athleteData'></tbody>
							</table>
						</div>

						<?php
						echo '</p>';
						echo '</div>';

					}
				?>

			  </div>

		</div>
	</div>

	{{-- @include('add-woddetail-modal'); --}}

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/wodresults.js') }}"></script>

</body>
</html>
