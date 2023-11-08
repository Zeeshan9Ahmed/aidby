@extends('service.layouts.master')
@section('title', 'Home')
@section('content')
<section class="gen-section">
    <div class="gen-wrap">
        <div class="topHeading d-flex align-items-center pb-5">
            
            <h1 class="headingMain ms-3">Service Detail</h1>
        </div>
        <form class="serviceBox1 relClass">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="genBar xy-between">
                        <p class="title pb-2">Service Name</p>
                    </div>
                    <div class="genCard1">
                        <div class="imgBox">
                            <img src="{{auth()->user()->profile_image?asset(auth()->user()->profile_image): asset('assets/images/user-image.png')}}" alt="img">
                        </div>
                        <div class="textBox">
                            <div class="genBar xy-between">
                                <div class="leftCol d-flex align-items-center">
                                    <p class="title me-3">{{$service->service->service_sub_category->title}}</p>
                                </div>

                                <p class="price"><span>$</span>{{$service->service->fixed_price}}</p>
                            </div>
                            <p class="desc">
                                {{$service->service->description}}
                            </p>
                        </div>
                    </div>
                    <div class="genBar xy-between">
                        <p class="title pb-2">Service Date</p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="genInput mb-2" value="{{\Carbon\Carbon::parse($service->start_date)->format('m/d/Y') }}" disabled>
                    </div>

                    <div class="genBar xy-between pb-2">
                        <p class="title">Service Time</p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="genInput mb-2" value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $service->time)->format('h:i A') }}" disabled>
                    </div>

                    <div class="genBar xy-between">
                        <p class="title pb-2">Payment Method</p>
                    </div>
                    <div class="form-group">
                        <input type="text" class="genInput mb-2" value="{{$service->payment_method}}" disabled>
                    </div>

                    <div class="genBar xy-between pb-2">
                        <p class="title">Additional Information</p>
                    </div>
                    <textarea class="genInput infoText" disabled>{{$service->additional_information}}</textarea>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="genBar xy-between pb-2">
                        <p class="title">Address</p>
                    </div>
                    @php
                    $address = $service->is_other_address=="1"?$service:$service->service_creator;
                    @endphp
                    <div class="genCard1 addressCard1">
                        <p class="desc">Address: <span>{{$address->location}}</span></p>
                        <p class="desc">City: <span>{{$address->city}}</span></p>
                        <p class="desc">State: <span>{{$address->state}}</span></p>
                    </div>
                    <div class="genBar xy-between pb-2">
                        <p class="title">Billing</p>
                    </div>
                    <div class="genCard1 addressCard1">
                        <div class="fig xy-between">
                            <p class="desc">Amount</p>
                            <span class="amount">${{$service->service->fixed_price}}</span>
                        </div>
                        <div class="fig type2 xy-between pt-3">
                            <p class="desc">Total Amount</p>
                            <span class="amount">${{$service->service->fixed_price}}</span>
                        </div>
                    </div>
                    <div class="genBar xy-between pb-2">
                        <p class="title">Problem Images</p>
                    </div>
                    <div class="uploadedImgs d-flex align-items-center">
                        @if($service->problem_images->isNotEmpty())
                        @foreach($service->problem_images as $image)
                        <div class="imgBox">
                            <img src="{{asset($image->attachment)}}" alt="img">
                        </div>
                        @endforeach
                        @else
                        @endif

                    </div>

                    @if ($service->status == 'in-progress')
                    <button class="genBtn type2 mt-4" type="button" id="markComplete">Mark as Completed</button>
                    @else
                    <button class="genBtn type1 mt-4" type="button">Completed</button>

                    @endif
                </div>
            </div>
        </form>
    </div>
</section>





@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var baseUrl = $('#baseUrl').val() + "/service";
        var markComplete = document.getElementById('markComplete');
        var id = @json($service->id);
        var type = @json($type);

        var clickHandler = function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            // console.log('clikc')
            $.ajax({
                type: "GET",
                url: baseUrl + "/mark-complete-service?id=" + id + "&type=" + type,

                dataType: "json",

                success: function(response) {
                    if (response.status > 0) {
                        markComplete.classList.remove('type2');
                        markComplete.classList.add('type1');

                        markComplete.innerHTML = 'Completed';
                        markComplete.removeEventListener('click', clickHandler);

                        not(response.message, 'success');

                    } else {
                        not(response.message, "error");
                    }
                },
            });

            // Remove the click event listener after it is clicked
        };

        markComplete.addEventListener('click', clickHandler);
    });
</script>
@endpush
@stack('scripts')