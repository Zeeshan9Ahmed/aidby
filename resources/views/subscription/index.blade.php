@extends('user.layouts.master')
@section('title', 'Subscription Plan')
@section('content')

<section class="gen-section">
	<div class="gen-wrap">
		<div class="subscriptionWrap">
			<p class="headingMain text-center">Flexible Plans</p>
			<p class="desc subsDesc text-center">Lorem ipsum dolor sit amet consectetur adipiscing elit dictum curabitur, sodales vel semper aliquet mollis sociis gravida magna, cum vulputate vehicula nunc augue arcu egestas aenean.</p>
			<div class="subscriptionRow xy-between">
				<div class="subsCard">
					<p class="title text-center">Monthly Subscription</p>
					<p class="price text-center">$19.99</p>
					<ul class="list-unstyled mt-4">
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
						<li class="desc pb-3"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
					</ul>
					<a href="{{ $url }}" class="genBtn planBtn">{{ $title }}</a>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection