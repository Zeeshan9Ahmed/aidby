@extends('service.layouts.master')
@section('title', 'Home')
@section('content')


<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading indexBar xy-between mb-4">
			<div class="leftWrap">
				<h1 class="headingMain">
					
					My Posted Service
				</h1>
			</div>
			<button class="genBtn type2 bookBtn" type="button" data-bs-toggle="modal" data-bs-target="#addServie">Create New Service</button>
		</div>
		<div class="row relClass pt-5">
			<button class="editBtn1 dltPost  clr4"  id="deleteService"><img src="{{asset('assets/images/edit-icon-2.png')}}" alt="img"></button>
			
			
			
		</div>
	</div>
</section>



<!--Add Service Modal Start-->
<div class="modal fade genModal" id="addServie" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<p class="headingMain text-center pb-3">Add Service</p>
				<form class="genForm row" method="post" id="service_form">
					{{-- <div class="col-12">
          <div class="uploadBox mb-3">
            <label id="wrapper" for="fileUpload" class="xy-center">
              <img src="assets/images/uploadIcon.png" alt="img">
              <p class="pt-2">Upload Image</p>
              <input id="fileUpload" class="d-none" type="file" multiple="" accept="image/gif, image/jpeg, image/png">
            </label>
            <button type="button" class="clearBtn xy-center">Clear All</button>
          </div>
          <div id="image-holder" class="pb-2"></div>
        </div>--}}

					<div class="col-12">
						<div class="form-group logInput mb-3">
							<select id="category_id" name="category_id" class="input1 ps-4">
								<option selected disabled value="">--Category--</option>
								@if(count($categories))
								@foreach($categories as $category)
								<option value="{{ $category->id }}">{{ $category->title }}</option>
								@endforeach
								@endif
							</select>
						</div>
					</div>

					<div class="col-12">
						<div class="form-group logInput mb-3" >
							<select class="input1 ps-4" id="sub_category_id" name="sub_category_id">
								<option selected disabled>-- Select Category First --</option>
								
							</select>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group logInput mb-3">
							<input type="text" placeholder="Fixed Price" name="fixed_price" id="fixed_price" maxlength="8" class="input1 ps-4">
						</div>
					</div>

					

						@csrf
					<div class="col-12">
						<div class="row mb-3">
							{{-- 
								<div class="col-lg-4 col-md-4 col-sm-6 col-6">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="license" value="1" id="license11" >
									<label class="desc form-check-label" for="license11">
										Licensed
									</label>
								</div>
							</div>
								
							<div class="col-lg-4 col-md-4 col-sm-6 col-6">
								<div class="form-check">
									<input class="form-check-input" type="radio" name="license" value="0" id="license22">
									<label class="desc form-check-label" for="license22">
										Un Licensed
									</label>
								</div>
							</div>

							--}}

							<div class="col-lg-4 col-md-4 col-sm-6 col-6">

							</div>
						</div>
					</div>

					<div class="col-12">
						<div class="form-group logInput mb-3">
							<textarea class="textarea1 input1 ps-4 pt-3" name="description" id="description" maxlength="275" placeholder="Description"></textarea>
						</div>
					</div>


					<div class="col-12">
						<button class="genBtn type2" id="service_button" type="button">Submit</button>
					</div>
				</form>
				<button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
			</div>
		</div>
	</div>
</div>
<!--Add Service Modal Start-->
<!--Delete Modal Start-->
<div class="modal fade genModal" id="Deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
       
       <form class="genForm row">
        <div class="col-12">
            <div class="row mb-3">
                <div class="col-12">
                    <p class="headingMain text-center pb-3">Do you want to delete this?</p>
                </div>
                <div class="col-lg-2 col-md-2"></div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-6">
              
            </div>
                <div class="col-lg-4 col-md-4 col-sm-6 col-6">
              
            </div>
                <div class="col-lg-2 col-md-2"></div>
            </div>
        </div>

        <div class="col-12">
          <button class="genBtn type2" id="confirm_delete" type="button">Delete</button>
          
        </div>
      </form>
       <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    </div>
   </div>
  </div>
</div>
<!--Delet Modal End-->


@endsection
@push('scripts')
<script>  var services = {!! json_encode($services) !!}; </script>
<script src="{{ asset('service_provider_assets/js/custom/home.js') }}">

</script>
@endpush
@stack('scripts')