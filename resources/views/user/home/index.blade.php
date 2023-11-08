@extends('user.layouts.master')
@section('title', 'Home')
@section('content')

<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading indexBar xy-between"> 
			<div class="leftWrap">
				<h1 class="headingMain">Hello {{ auth()->user()->first_name }}!</h1>

				<div class="form-group logInput">
					<select class="input1 ps-4" onchange="location = this.value;">
						<option value="" selected disabled>-- Select City --</option>
						@if(count($services) > 0)
						@foreach($services as $service)
						<option value="{{ url('user/service-city', str_replace(' ', '-', strtolower($service->city)) ) }}">{{ $service->city }}</option>
						@endforeach
						@endif
					</select>
				</div>
			</div>
			<button class="genBtn type2 bookBtn" type="button" data-bs-toggle="modal" data-bs-target="#bookModal">Book Now</button>
		</div>

		<div class="swiper indexSlide pt-4 pb-4">
			<div class="swiper-wrapper">
				@if(count($categories) > 0)
				@foreach($categories as $key => $category)
				<div class="swiper-slide" id="home-category" data-id="{{ $category->id }}">
					<div class="indexCard">
						<div class="imgBox">
							@if(!empty($category->image))
							<img src="{{ asset($category->image) }}" alt="img" class="w-100">
							@else
							<img src="{{ asset('assets/images/no-image.png') }}" alt="img" class="w-100">
							@endif
						</div>
						<p class="desc">{{ ucwords($category->title) }}</p>
					</div>
				</div>
				@endforeach
				@endif
			</div>
		</div>

		<div class="topHeading type2 d-flex align-items-center pb-3"> 
			<h1 class="headingMain">Select Category</h1>
		</div>

		<div class="row catWarp" id="sub-category-div">
			<p class="title">Please select category</p>
		</div>
	</div>
</section>


@endsection
@push('scripts')
<script src="{{ asset('assets/js/custom/user/user.js') }}"></script>
@endpush