@extends('user.layouts.master')
@section('title', 'My profile')
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
			<h1 class="headingMain ms-3">My Profile</h1>
		</div>

		<div class="profileRow">
			<div class="myProfileBox">
				<div class="imgBox text-center mb-3">
					@if(auth()->user()->profile_image)
					<img src="{{ asset(auth()->user()->profile_image) }}" alt="img">
					@else
					<img src="{{ asset('assets/images/user-image.png') }}" alt="img">
					@endif
				</div>
				<p class="name pb-3">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>

				<div class="infoWrap">
					<p>Phone: <span>{{ auth()->user()->phone_number }}</span></p>
					<p class="desc">Address: <span>{{ auth()->user()->location }}</span></p>
					<p>City: <span>{{ auth()->user()->city }}</span></p>
					<p>State: <span>{{ auth()->user()->state }}</span></p>
				</div>
				<a href="{{ url('user/complete-profile') }}" class="editBtn1 xy-center">
					<img src="{{ asset('assets/images/edit-icon.png') }}" alt="img">
				</a>
			</div>
			<div class="profileRight_tabSect">
				<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="pills-bookedservices-tab" data-bs-toggle="pill" data-bs-target="#pills-bookedservices" type="button" role="tab" aria-controls="pills-bookedservices" aria-selected="false">Booked Services</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="pills-allservices-tab" data-bs-toggle="pill" data-bs-target="#pills-allservices" type="button" role="tab" aria-controls="pills-allservices" aria-selected="true">Hire Services</button>
					</li>
				</ul>
				<div class="tab-content" id="pills-tabContent">
					<div class="tab-pane fade show active" id="pills-bookedservices" role="tabpanel" aria-labelledby="pills-bookedservices-tab">
						<div class="myProfileTable">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Category</th>
										<th scope="col">Sub Category</th>
										<th scope="col">Per Hour Rate</th>
										<th scope="col">Date</th>
										<th scope="col">Time</th>
										<th scope="col">Rating</th>
										<th scope="col">Status</th>
										<th scope="col">Give Review</th>
									</tr>
								</thead>
								<tbody>
									@if(count($bookings) > 0)
									@foreach($bookings as $booking)
									<tr>
										<td>{{ ucwords($booking->category->title) }}</td>
										<td>{{ ucwords($booking->sub_category->title) }}</td>
										<td>${{ number_format($booking->per_hour_rate) }}</td>
										<td>{{ Carbon\Carbon::parse($booking->date)->format('m-d-Y') }}</td>
										<td>{{ Carbon\Carbon::parse($booking->time)->format('h:i A') }}</td>
										<td>
											@if($booking->avg_rating != null && $booking->avg_rating > 0)
											<i class="fa-solid fa-star"></i> 
											{{ $booking->avg_rating }}
											@endif
										</td>
										<td>{{ ucfirst($booking->status) }}</td>
										<td>
											@if($booking->avg_rating == 0 && $booking->status == 'completed')
											<a href="javascript:void(0);" title="Review" data-id="{{ $booking->id }}" data-type="booking" data-user-service-id="{{ $booking->completed_by }}" class="give-review">
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
										<td colspan="8">No booking found.</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
					<div class="tab-pane fade" id="pills-allservices" role="tabpanel" aria-labelledby="pills-allservices-tab">
						<div class="myProfileTable">
							<table class="table">
								<thead>
									<tr>
										<th scope="col">Category</th>
										<th scope="col">Sub Category</th>
										<th scope="col">Fixed Price</th>
										<th scope="col">Start Date</th>
										<th scope="col">End Date</th>
										<th scope="col">Time</th>
										<th scope="col">Rating</th>
										<th scope="col">Status</th>
										<th scope="col">Give Review</th>
									</tr>
								</thead>
								<tbody>
									@if(count($bookServices) > 0)
									@foreach($bookServices as $bookService)
									<tr>
										<td>{{ ucwords($bookService->service->service_category->title) }}</td>
										<td>{{ ucwords($bookService->service->service_sub_category->title) }}</td>
										<td>${{ number_format($bookService->service->fixed_price) }}</td>
										<td>{{ Carbon\Carbon::parse($bookService->start_date)->format('m-d-Y') }}</td>
										<td>{{ Carbon\Carbon::parse($bookService->end_date)->format('m-d-Y') }}</td>
										<td>{{ Carbon\Carbon::parse($bookService->time)->format('h:i A') }}</td>
										<td>
											@if($bookService->avg_rating != null && $bookService->avg_rating > 0)
											<i class="fa-solid fa-star"></i> 
											{{ $bookService->avg_rating }}
											@endif
										</td>
										<td>{{ ucfirst($bookService->status) }}</td>
										<td>
											@if($bookService->avg_rating == 0 && $bookService->status == 'completed')
											<a href="javascript:void(0);" title="Review" data-id="{{ $bookService->id }}" data-type="book_service" data-user-service-id="{{ $bookService->service->user_id }}" class="give-review">
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
										<td colspan="9">No booked service found.</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
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
				<form class="genForm row" method="post" action="{{ url('user/review') }}"> @csrf
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
<script src="{{ asset('assets/js/custom/user/profile.js') }}"></script>
@endpush