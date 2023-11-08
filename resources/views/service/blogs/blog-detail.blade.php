@extends('service.layouts.master')
@section('title', 'Home')
@section('content')
<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading d-flex align-items-center pb-5"> 
			<h1 class="headingMain ms-3">Blog Detail</h1>
		</div>

		<div class="blogDetail">
			<div class="imgBox mb-4"><img src="{{asset($blog->blog_image)}}" alt="img" class="img-fluid"></div>

			<div class="xy-between flex-wrap">
				<h1 class="heading">{{$blog->sub_category->title}}</h1>

				<div class="detailInfo row align-items-center">
					<div class="col-6">
						<div class="blogPoster d-flex align-items-center">
							<img src="{{$blog->user->profile_image ? asset($blog->user->profile_image) : asset('assets/images/nav-icon-2.png')}}" alt="img">
							<p class="name">{{$blog->user->first_name }} {{$blog->user->last_name }}</p>
						</div>
					</div>
					<div class="col-6 text-end">
						<div class="xy-end ">
							<img src="{{asset('assets/images/calender1.png')}}" alt="img">
							<p class="desc ms-2">{{$blog->created_at->format('j F Y')}}</p>
						</div>
					</div>
				</div>
			</div>
			<p class="desc mt-4">
			{{$blog->description}}
            </p>
		</div>
	</div>
</section>



@endsection
@push('scripts')
<script>
  
</script>
@endpush
@stack('scripts')