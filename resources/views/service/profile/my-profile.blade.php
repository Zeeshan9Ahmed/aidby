@extends('service.layouts.master')
@section('title', 'Home')
@section('content')


<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading d-flex align-items-center pb-5">
			
			<h1 class="headingMain ms-3">My Profile</h1>
		</div>

		<div class="profileRow">
			<div class="myProfileBox clientProfileBox">
				<div class="imgBox text-center mb-3">
					<img src="{{auth()->user()->profile_image?asset(auth()->user()->profile_image):asset('service_provider_assets/images/mem1.png')}}" alt="img">
				</div>
				<p class="name pb-3">{{ auth()->user()->first_name}} {{ auth()->user()->last_name  }}</p>

				<div class="infoWrap pb-5">
					<p>Phone: <span>{{auth()->user()->phone_number}}</span></p>

					<p class="desc">Address: <span>{{ auth()->user()->location}}</span></p>

					<p>City: <span>{{ auth()->user()->city}}</span></p>

					<p>State: <span>{{ auth()->user()->state}}</span></p>

					<p>Member Since: <span> {{ auth()->user()->created_at->format('M d Y')}}</span></p>


				</div>

				<a href="{{url('service/complete-profile')}}" class="editBtn1 xy-center">
					<img src="{{ asset('assets/images/edit-icon.png') }}" alt="img">
				</a>
			</div>
			<div class="myProfileTable clientProfileTable">
				<h1 class="headingMain pb-3">Posted Service</h1>


				<div class="row">



					@if (!$services->isEmpty())

					@foreach ($services as $service)

					<div class="col-lg-6 col-md-6 col-sm-12">
						<div class="genCard1">
							<div class="imgBox">
								<img src="{{auth()->user()->profile_image?asset(auth()->user()->profile_image):asset('service_provider_assets/images/mem1.png')}}" alt="img">
								<p class="title text-center mt-2">{{auth()->user()->first_name}}  {{auth()->user()->last_name}}</p>
							</div>
							<div class="textBox">
								<div class="topBar xy-between">
									<div class="leftCol d-flex align-items-center">
										<p class="title me-3">{{$service->service_sub_category->title}}</p>
									</div>
									<!-- <p class="price"><span>$</span>20.00</p> -->
								</div>
								<div class="xy-between pt-2 pb-2 pe-4">
									<p class="desc">Fixed Price: ${{$service->fixed_price}}</p>
									{{-- <p class="desc">Hourly Rate: ${{$service->per_hour_rate}}</p>--}}
								</div>
								<p class="desc">
									{{$service->description}}
								</p>
							</div>
						</div>
					</div>
					
					@endforeach

					@else
					
						<p>No Data Found</p>
					@endif





				</div>
			</div>
		</div>

	</div>
</section>

@endsection
@push('scripts')
<script src="{{ asset('service_provider_assets/js/custom/profile.js') }}">

</script>
@endpush
@stack('scripts')