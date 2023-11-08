@extends('user.layouts.master')
@section('title', 'Category service')
@section('content')

<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading d-flex align-items-center pb-5"> 
			<h1 class="headingMain ms-3">{{ ucwords($category->title) }}</h1>
		</div>
		<div class="row">
            @if(count($category->services) > 0)
            @foreach($category->services as $service)
			<div class="col-lg-4 col-md-4 col-sm-6 col-12">
				<div class="genCard1">
					<div class="imgBox">
                        @if(!empty($service->service_provider->profile_image))
                        <img src="{{ asset($service->service_provider->profile_image) }}" alt="img" class="userImg">
                        @else
                        <img src="{{ asset('assets/images/user-image.png') }}" alt="img" class="userImg">
                        @endif
					</div>
					<div class="textBox">
						<div class="topBar xy-between">
							<div class="leftCol d-flex align-items-center">
								<p class="title me-3">{{ $service->service_provider->first_name }} {{ $service->service_provider->last_name }}</p>
								<p class="ratingStar"><i class="fa-solid fa-star"></i> {{ round($service->avg_rating) }}</p>
							</div>
							<p class="price"><span>$</span>{{ number_format($service->fixed_price) }}</p>
						</div>
						<p class="desc">{{ $service->description }}</p>

						<div class="btnWrap xy-between pt-3">
							<a href="{{ url('user/book-service', $service->id) }}" class="cardBtn me-1">Hire</a>
							{{-- <a href="#paymentNow" data-bs-toggle="modal" class="cardBtn me-1">Interview Now</a> --}}
							<a href="{{ url('user/chat', $service->service_provider->id) }}" class="cardBtn me-1">Interview Now</a>
						</div>
					</div>
				</div>
			</div>
            @endforeach
			@else
			<p class="title">Services not found.</p>
            @endif
		</div>
	</div>
</section>

@endsection