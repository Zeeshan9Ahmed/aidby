@extends('service.layouts.master')
@section('title', 'Booking')
@section('content')

<style>
	* {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}

	*:before,
	*:after {
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}

	.clearfix {
		clear: both;
	}

	.text-center {
		text-align: center;
	}

	a {
		color: tomato;
		text-decoration: none;
	}

	a:hover {
		color: #2196f3;
	}

	pre {
		display: block;
		padding: 9.5px;
		margin: 0 0 10px;
		font-size: 13px;
		line-height: 1.42857143;
		color: #333;
		word-break: break-all;
		word-wrap: break-word;
		background-color: #F5F5F5;
		border: 1px solid #CCC;
		border-radius: 4px;
	}

	.header {
		padding: 20px 0;
		position: relative;
		margin-bottom: 10px;

	}

	.header:after {
		content: "";
		display: block;
		height: 1px;
		background: #eee;
		position: absolute;
		left: 30%;
		right: 30%;
	}

	.header h2 {
		font-size: 3em;
		font-weight: 300;
		margin-bottom: 0.2em;
	}

	.header p {
		font-size: 14px;
	}



	#a-footer {
		margin: 20px 0;
	}

	.new-react-version {
		padding: 20px 20px;
		border: 1px solid #eee;
		border-radius: 20px;
		box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);

		text-align: center;
		font-size: 14px;
		line-height: 1.7;
	}

	.new-react-version .react-svg-logo {
		text-align: center;
		max-width: 60px;
		margin: 20px auto;
		margin-top: 0;
	}





	.success-box {
		margin: 50px 0;
		padding: 10px 10px;
		border: 1px solid #eee;
		background: #f9f9f9;
	}

	.success-box img {
		margin-right: 10px;
		display: inline-block;
		vertical-align: top;
	}

	.success-box>div {
		vertical-align: top;
		display: inline-block;
		color: #888;
	}



	/* Rating Star Widgets Style */
	.rating-stars ul {
		list-style-type: none;
		padding: 0;

		-moz-user-select: none;
		-webkit-user-select: none;
	}

	.rating-stars ul>li.star {
		display: inline-block;

	}

	/* Idle State of the stars */
	.rating-stars ul>li.star>i.fa {
		font-size: 2.5em;
		/* Change the size of the stars */
		color: #ccc;
		/* Color on idle state */
	}

	/* Hover state of the stars */
	.rating-stars ul>li.star.hover>i.fa {
		color: #FFCC36;
	}

	/* Selected state of the stars */
	.rating-stars ul>li.star.selected>i.fa {
		color: #FF912C;
	}
</style>

<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading d-flex align-items-center pb-5">

			<h1 class="headingMain ms-3">My Bookings</h1>
		</div>

		<div class="tableWrap">
			<ul class="nav nav-pills mb-3 serviceTab" id="pills-tab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="pills-service1-tab" data-bs-toggle="pill" data-bs-target="#pills-service1" type="button" role="tab">Ongoing Services</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-service2-tab" data-bs-toggle="pill" data-bs-target="#pills-service2" type="button" role="tab">Previous Services</button>
				</li>
			</ul>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-service1" role="tabpanel">
					<select id="filter" class="tableFilter genBtn type2 text-center">
						<option selected value="all">All</option>
						<option value="monthly">Monthly</option>
						<option value="yearly">Yearly</option>
					</select>
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Title</th>
								<th scope="col">Date</th>
								<th scope="col">User Name</th>
								<th scope="col">Payment Method</th>
								<th scope="col">Per Hour Rate</th>
								<th scope="col">Fixed Price</th>
								<th scope="col">Service Type</th>
								<th scope="col">View</th>
							</tr>
						</thead>
						<tbody id="services_body">


						</tbody>
					</table>
				</div>
				<div class="tab-pane fade" id="pills-service2" role="tabpanel">
					<div class="myProfileTable serviceTable w-100">
						<table class="table">
							<thead>
								<tr>
									<th scope="col">Title</th>
									<th scope="col">Date</th>
									<th scope="col">User Name</th>
									<th scope="col">Payment Method</th>
									<th scope="col">Per Hour Rate</th>
									<th scope="col">Fixed Price</th>
									<th scope="col">Service Type</th>
									<th scope="col">Ratings</th>
									<th scope="col">Status</th>
									<th scope="col">Give Review</th>
								</tr>
							</thead>
							<tbody>
								@if(count($completed_services) > 0)
								@foreach($completed_services as $completed_service)
								<tr>
									@if($completed_service->type == "URGENT")
										@php $type = "booking"; @endphp
									@else
										@php $type = "book_service"; @endphp
									@endif
									<td>{{$completed_service->title}}</td>
									<td>{{ \Carbon\Carbon::parse($completed_service->date)->format('m/d/Y') }}</td>
									<td>{{$completed_service->first_name}} {{$completed_service->last_name}}</td>
									<td>{{$completed_service->payment_method}}</td>
									<td> @if($completed_service->type == "URGENT") ${{$completed_service->hourly_rate}} @else -- @endif</td>
									<td>@if($completed_service->type == "NORMAL") ${{$completed_service->hourly_rate}} @else -- @endif</td>
									<td>{{$completed_service->type}}</td>
									<td>
										@if($completed_service->avg_rating != null && $completed_service->avg_rating > 0)
										<i class="fa-solid fa-star"></i> 
										{{ $completed_service->avg_rating }}
										@endif
									</td>
									<td>Completed</td>
									<td>
										@if($completed_service->avg_rating == null)
										<a href="javascript:void(0);" title="Review" data-id="{{ $completed_service->id }}" data-type="{{ $type }}" data-user-service-id="{{ auth()->id() }}" data-user-id="{{ $completed_service->user_id }}" class="give-review">
											<i class="fa-solid fa-thumbs-up"></i>
										</a>
										@else
										- - -
										@endif
									</td>
								</tr>
								@endforeach
								@else
								<tr>
									<th>
										<p class="noData">Data not found</p>
									</th>
								</tr>
								@endif 
							</tbody>
						</table>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- Submit Review Modal Start-->
<div class="modal fade genModal" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="headingMain text-center pb-3 pt-4">Submit a Review</p>
                <form class="genForm row" method="post" action="{{ url('service/review') }}"> @csrf
					<div class="col-12">
						<div class='rating-stars text-center mb-2'>
							<ul id='stars'>
								<li class='star' title='Poor' data-value='1'>
									<i class='fa fa-star fa-fw'></i>
								</li>
								<li class='star' title='Fair' data-value='2'>
									<i class='fa fa-star fa-fw'></i>
								</li>
								<li class='star' title='Good' data-value='3'>
									<i class='fa fa-star fa-fw'></i>
								</li>
								<li class='star' title='Excellent' data-value='4'>
									<i class='fa fa-star fa-fw'></i>
								</li>
								<li class='star' title='WOW!!!' data-value='5'>
									<i class='fa fa-star fa-fw'></i>
								</li>
							</ul>
						</div>
                    </div>
                    <div class="col-12">
                        <div class="form-group logInput mb-3">
							<input type="hidden" name="rating" id="rating-g" required value="1">
                            <textarea class="textarea1 input1 ps-4 pt-3" placeholder="Type a review" name="review" required></textarea>
                        </div>
                    </div>
                    <div class="col-12">
						<input type="hidden" name="user_service_id" id="user_service_id" required>
						<input type="hidden" name="record_id" id="record_id" required>
						<input type="hidden" name="user_id" id="user_id" required>
						<input type="hidden" name="type" id="type" required>
                        <button class="genBtn" type="submit">Submit</button>
                    </div>
                </form>
                <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
<!--Submit Review Modal End-->

@endsection
@push('scripts')

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Your code here
		// This code will run after the DOM content has finished loading
		var baseUrl = document.getElementById('baseUrl').value + "/service";
		var services = @json($services);
		// console.log(services,'services')

		function loadServices(services) {
			html = services.map((service) => {
				return `<tr>
	
					<td>${service?.title}</td>
					<td>${formatDate(service?.date)}</td>
					<td>${service?.first_name} ${service?.last_name}</td>
					<td>${service?.payment_method}</td>
					<td>${service.type == "URGENT"? `$${service?.hourly_rate}`:"--" }</td>
					<td>${service.type == "NORMAL"? service?.hourly_rate:"--" }</td>
					
					<td>${service?.type}</td>
					<td><a href="${baseUrl}/service-detail/${service?.type.toLowerCase()}/${service.id}" class="viewMore"><i class="fa-solid fa-eye"></i></td>
	
				</tr>`;
			}).join("");
			// console.log(html.length,'sd')
			return html ? html : `<p class="noData">Data not found</p>`;
		}

		service_body = document.getElementById('services_body')
		service_body.innerHTML = loadServices(services);
		// console.log(loadServices(services))
		filter = document.getElementById('filter')

		filter.addEventListener('change', function() {
			var selectedValue = filter.value;
			date = new Date();
			if (selectedValue == "all") {
				data = services;
			} else if (selectedValue == "monthly") {
				data = filterDataByMonthOrYear(services, date.getMonth(), null);
			} else {
				data = filterDataByMonthOrYear(services, null, date.getFullYear());

			}

			service_body.innerHTML = loadServices(data);

		});


		function filterDataByMonthOrYear(data, month, year) {
			return data.filter(function(item) {
				var itemDate = new Date(item.date);
				var itemMonth = itemDate.getMonth();

				var itemYear = itemDate.getFullYear();

				return (!month || itemMonth === month) && (!year || itemYear === year);
			});
		}

		function capitalizeFirstLetter(str) {

			return str.charAt(0).toUpperCase() + str.slice(1);
		}

		function formatDate(dateStr) {
			var parts = dateStr.split("-");
			return parts[1] + "/" + parts[2] + "/" + parts[0];
		}
		// console.log(!!loadServices([]))
	});

	/** Create review */
	$(document).on('click', '.give-review', function () {
		var id = $(this).attr('data-id');
		var type = $(this).attr('data-type');
		var user_id = $(this).attr('data-user-id');
		var user_service_id = $(this).attr('data-user-service-id');
		$('#type').val(type);
		$('#record_id').val(id);
		$('#user_id').val(user_id);
		$('#user_service_id').val(user_service_id);
		$('#reviewModal').modal('show');
	});
</script>
@endpush
@stack('scripts')