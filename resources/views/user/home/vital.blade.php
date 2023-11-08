@extends('user.layouts.master')
@section('title', 'Vital')
@section('content')

<style>
	.line-chart {
		animation: fadeIn 600ms cubic-bezier(.57, .25, .65, 1) 1 forwards;
		width: 100%;
		margin-bottom: 25px;
	}

	.line-chart h3 {
		color: #fff;
		font-size: 16px;
		padding-bottom: 13px;
	}

	.aspect-ratio {
		height: 0;
		padding-bottom: 50%; // 495h / 990w}

		@keyframes fadeIn {
			to {
				opacity: 1;
			}
		}


		.vital_div {
			background: #ffffff;
			width: 90%;
			margin: 0 auto;
			padding: 20px;
			border-radius: 25px;
			box-shadow: 0px 0px 7px #cdcdcd;
		}

		.vital-div-bl {
			background: #01183b;
			padding: 10px;

			border-radius: 10px;
		}

		.vital-div-bl h3 {
			color: #fff;
			font-size: 16px;
			padding-bottom: 12px;
			font-weight: bold;
		}

		.pain-cont {
			display: flex;
			align-items: center;
			justify-content: center;
		}

		#donut {
			width: 150px;
			height: 150px;

		}

		path.color0 {
			fill: #fff;
		}

		path.color1 {
			fill: #ff591b;
		}

		text {
			font-family: "RamaGothicM-Heavy", Impact, Haettenschweiler, "Franklin Gothic Bold", Charcoal, "Helvetica Inserat", "Bitstream Vera Sans Bold", "Arial Black", sans-serif;
			font-size: 22px;
			font-weight: 400;
			line-height: 16rem;
			fill: #fff;
		}

		.pain-text h4 {
			color: #fff;
			font-size: 16px;
			padding-bottom: 12px;
			font-weight: bold;
		}

		.pain-text p {
			color: #fff;
			font-size: 14px;
		}

		.pain-chart {
			margin: 10px;
		}

		@media only screen and (max-width: 600px) {
			.pain-cont {
				display: inherit;
			}
		}
</style>

<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading indexBar xy-between mb-5">
			<div class="leftWrap">
				<h1 class="headingMain ms-3"> Vital </h1>
			</div>
			<div class="subsBtn xy-between">
				@if(!$isAddVital)
				<a href="#!" class="genBtn type2 bookBtn" type="button" data-bs-toggle="modal" data-bs-target="#vitalModal">Add Vital</a>
				@endif
			</div>
		</div>
		<div class="subscriptionWrap vital_div">
			<div class="row">
				<div class="col-12 col-md-6 col-lg-6">
					<div class="line-chart" style="background: #01183b;padding: 18px;border-radius: 10px;">
						<h3>Heart Rate</h3>
						<div class="aspect-ratio"><canvas id="chart"></canvas></div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-6">
					<div class="line-chart" style="background: #01183b;padding: 18px;border-radius: 10px;">
						<h3>Blood Pressure</h3>
						<canvas id="speedChart"></canvas>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12">
					<div class="myProfileTable" style="width:100%">
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Date</th>
									<th scope="col">Time</th>
									<th scope="col">Heart Rate</th>
									<th scope="col">Blood Pressure</th>
									<th scope="col">Pain</th>
									<th scope="col">Hydration</th>
									<th scope="col">Weight</th>
								</tr>
							</thead>
							<tbody>
								@if(count($vitals) > 0)
								@foreach($vitals as $vital)
								<tr>
									<td>{{ Carbon\Carbon::parse($vital->created_at)->format('d-m-Y') }}</td>
									<td>{{ Carbon\Carbon::parse($vital->created_at)->format('h:i A') }}</td>
									<td>{{ $vital->heart_rate }}</td>
									<td>{{ $vital->blood_pressure }}</td>
									<td>{{ $vital->pain }}</td>
									<td>{{ $vital->hydration }}</td>
									<td>{{ $vital->weight }} Kg</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="7">No vital found.</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
</section>

@endsection
@push('scripts')

<script>
	function formatDate(date) {
		var d = new Date(date),
			month = '' + (d.getMonth() + 1),
			day = '' + d.getDate(),
			year = d.getFullYear();

		if (month.length < 2) month = '0' + month;
		if (day.length < 2) day = '0' + day;

		return [day, month, year].join('-');
	}

	$(document).ready(function() {

		$.get("{{ url('user/vital-data') }}", function(response) {

			var heart_rate_data = [];
			var created_at = [];
			var blood_pressure_down = [];
			var blood_pressure_up = [];

			$.each(response, function(index, value) {

				heart_rate_data.push(value.heart_rate);
				created_at.push(formatDate(value.created_at));

				blood_pressure_down.push(value.blood_pressure.split('/')[0]);
				blood_pressure_up.push(value.blood_pressure.split('/')[1]);
			});

			heart_rate(heart_rate_data, created_at);
			blood_pressure(blood_pressure_down, blood_pressure_up, created_at);

		}, 'json');


		function heart_rate(heart_data, created_at) {
			var chart = document.getElementById('chart').getContext('2d'), gradient = chart.createLinearGradient(0, 0, 0, 450);

			gradient.addColorStop(0, 'rgba(255, 255,255, 0.9)');
			gradient.addColorStop(0.7, 'rgba(255, 255, 255, 0.25)');
			gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');


			var data = {
				labels: created_at,
				datasets: [{
					label: 'Heart Rate',
					backgroundColor: gradient,
					pointBackgroundColor: 'white',
					borderWidth: 1,
					borderColor: '#fff',
					data: heart_data
				}]
			};


			var options = {
				responsive: true,
				maintainAspectRatio: true,
				animation: {
					easing: 'easeInOutQuad',
					duration: 520
				},
				scales: {
					xAxes: [{
						gridLines: {
							color: 'rgba(255, 255, 255, 0.9)',
							lineWidth: 0.1
						}
					}],
					yAxes: [{
						gridLines: {
							color: 'rgba(255, 255, 255, 0.9)',
							lineWidth: 0.1
						}
					}]
				},
				elements: {
					line: {
						tension: 0.1
					}
				},
				legend: {
					display: false
				},
				point: {
					backgroundColor: 'white'
				},
				tooltips: {
					titleFontFamily: 'Open Sans',
					backgroundColor: 'rgba(0,0,0,0.3)',
					titleFontColor: 'red',
					caretSize: 5,
					cornerRadius: 2,
					xPadding: 10,
					yPadding: 10
				}
			};


			var chartInstance = new Chart(chart, {
				type: 'line',
				data: data,
				options: options
			});
		}

		function blood_pressure(blood_pressure_down, blood_pressure_up, created_at) {
			var speedCanvas = document.getElementById("speedChart");
			var dataFirst = {
				label: "upper (systolic)",
				data: blood_pressure_up,
				lineTension: 0,
				fill: false,
				borderColor: '#ff5a1c'
			};

			var dataSecond = {
				label: "lower (diastolic)",
				data: blood_pressure_down,
				lineTension: 0,
				fill: false,
				borderColor: '#ffffff'
			};

			var speedData = {
				labels: created_at,
				datasets: [dataFirst, dataSecond]
			};

			var chartOptions = {
				legend: {
					display: true,
					position: 'top',
					labels: {
						boxWidth: 80,
						fontColor: 'white'
					}
				},
				scales: {
					xAxes: [{
						gridLines: {
							color: 'rgba(255, 255, 255, 0.9)',
							lineWidth: 0.1
						}
					}],
					yAxes: [{
						gridLines: {
							color: 'rgba(255, 255, 255, 0.9)',
							lineWidth: 0.1
						}
					}]
				},
			};

			var lineChart = new Chart(speedCanvas, {
				type: 'line',
				data: speedData,
				options: chartOptions,

			});
		}
	});
</script>

@endpush