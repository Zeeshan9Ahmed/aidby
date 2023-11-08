@extends('user.layouts.master')
@section('title', 'My profile')
@section('content')

<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading d-flex align-items-center pb-5"> 
			<h1 class="headingMain ms-3">My Booking</h1>
		</div>

		<div class="profileRow">
			<div class="profileRight_tabSect w-100">
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
                    <div class="col-12 pb-2">
                        <div class="reviewImg text-center">
                            <img src="{{ asset('assets/images/mem1.png') }}" alt="img">
                        </div>
                        <p class="title text-center">Martin Joseph</p>
                        <div class="rating">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <i class="fas fa-star emptyStar" aria-hidden="true"></i>
                        </div>
                    </div>
					<div class="col-12">
                        <div class="form-group logInput mb-3">
							<select class="input1 ps-4" name="rating" required>
								<option disabled value="" selected>-- Select Rate --</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group logInput mb-3">
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