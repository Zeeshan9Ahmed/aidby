@extends('service.layouts.master')
@section('title', 'Home')
@section('content')


<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading indexBar xy-between mb-5"> 
			<div class="leftWrap">

				<h1 class="headingMain ms-3"><a href="#!" class="">
				<img src="{{asset('assets/images/back-button.png')}}" alt="img">
			</a> Subscription Packages</h1>
			</div>
			<div class="subsBtn xy-between">	
				<a href="#!" class="genBtn type2 bookBtn" type="button">Add Vital</a>
				<select class="genBtn type2 text-center">
					<option selected>Daily</option>
					<option>Lorem, ipsum.</option>
					<option>Lorem, ipsum.</option>
					<option>Lorem, ipsum.</option>
				</select>
			</div>
		</div>

		<div class="subscriptionWrap">
			<p class="headingMain text-center">Flexible Plans</p>
			<p class="desc subsDesc text-center">Lorem ipsum dolor sit amet consectetur adipiscing elit dictum curabitur, sodales vel semper aliquet mollis sociis gravida magna, cum vulputate vehicula nunc augue arcu egestas aenean.</p>


			<div class="subscriptionRow xy-between">
				<div class="subsCard"> 
					<p class="title text-center">Basic</p>
					<p class="price text-center">$20.00</p>

					<ul class="list-unstyled mt-4">
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
					</ul>
					<button class="genBtn planBtn">Choose Plan</button>
				</div>
				<div class="subsCard">
					<p class="title text-center">Standard</p>
					<p class="price text-center">$30.00</p>

					<ul class="list-unstyled mt-4">
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
					</ul>
					<button class="genBtn planBtn">Choose Plan</button>
				</div>
				<div class="subsCard">
					<p class="title text-center">Professional</p>
					<p class="price text-center">$40.00</p>

					<ul class="list-unstyled mt-4">
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
					</ul>
					<button class="genBtn planBtn">Choose Plan</button>
				</div>
			</div>
		</div>
	</div>
</section>



@endsection
@push('scripts')
<script src="{{ asset('service_provider_assets/js/custom/home.js') }}">

</script>
@endpush
@stack('scripts')