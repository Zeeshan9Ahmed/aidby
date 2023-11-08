@extends('service.layouts.master')
@section('title', 'Home')
@section('content')



<section class="gen-section">
    <div class="gen-wrap">

        <p class="headingMain type2 pb-3">Service Requests</p>
        <div class="row">
            @if (!$requests->isEmpty() )
            @foreach($requests as $request)
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                <div class="genCard1 genCard2 requests-page">
                    <div class="imgBox">
                        <div class="imgBox_img">
                            <img src="{{$request->profile_image?asset($request->profile_image):asset('assets/images/mem1.png')}}" alt="img">
                            <p class="title text-center mt-2">{{$request->first_name}} {{$request->last_name }} </p>
                        </div>
                        <div class="imgBox_detail">
                            <!-- <p class="desc text-center mt-2">{{$request->first_name}} {{$request->last_name }} </p> -->
                            <div class="imgBox_detailDesc">
                                <p class="title">Category:</p>
                                <p class="desc">{{$request->category }}</p>
                            </div>
                            <div class="topBar xy-between">
                            <div class="leftCol d-flex align-items-center sub-category-text">
                            <p class="title">Sub-Category:</p>
                                <p class="desc">{{$request->sub_category}}</p>
                            </div>  <div class="imgBox_detailDesc">
                                <p class="title">Type: </p>
                                <p class="desc">{{$request->type }} </p>
                            </div>
                            @if ($request->type == "NORMAL")
                            <p class="price">Fixed Price: <span>$</span>{{$request->fixed_price}}</p>
                            @else
                            <p class="price">Hourly Rate: <span>$</span>{{$request->per_hour_rate}}</p>
                            @endif 
                        </div>
                          
                        </div>
                    </div>
                    <div class="textBox Date-box">
                        
                        <div class="xy-between pt-2 pb-2 pe-4">
                            <p class="desc"><strong>Start Date:</strong> {{  \Carbon\Carbon::parse($request->start_date)->format('m/d/Y')   }}</p>
                            <p class="desc"><strong>End Date:</strong> {{\Carbon\Carbon::parse($request->end_date)->format('m/d/Y') }}</p>
                            <p class="desc"><strong>Time:</strong> {{\Carbon\Carbon::createFromFormat('H:i:s', $request->time)->format('h:i A')  }}</p>
                        </div>
                        <p class="desc reque-text">
                            {{$request->additional_information}}
                        </p>

                        <div class="btnWrap xy-between pt-3 request-button">
                            <button id="reject" class="cardBtn me-1 reject" data-service-type="{{$request->type}}" data-id="{{$request->id}}">Reject</button>
                            <button id="accept" class="cardBtn ms-1 clrA accept" data-service-type="{{$request->type}}" data-id="{{$request->id}}">Accept</button>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            @else
            <p class="noData">Data not found</p>
            @endif


        </div>
    </div>
</section>


<!--Delete Modal Start-->
<div class="modal fade genModal" id="Deletemodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">

                <form class="genForm row">
                    <div class="col-12">
                        <div class="row mb-3">
                            <div class="col-12">
                                <p class="headingMain text-center pb-3">Are you sure?</p>
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
                        <button class="genBtn type2" id="confirm_delete" type="button">Yes</button>

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

<script>
    var requestId = ''
    var type = "";
    var service_type = "";
    var baseUrl = document.getElementById('baseUrl').value + "/service";
    rejectButtons = document.querySelectorAll('.reject');

    var div = "";
    rejectButtons.forEach(function(rejectButton) {
        rejectButton.addEventListener('click', function() {
            service_type = this.getAttribute('data-service-type')
            div = this.parentNode.parentNode.parentNode.parentNode
            type = "reject"
            requestId = this.getAttribute('data-id')
            openModal()
        });

    })
    acceptButtons = document.querySelectorAll('.accept');
    acceptButtons.forEach(function(acceptButton) {
        acceptButton.addEventListener('click', function() {
            type = "accept"
            div = this.parentNode.parentNode.parentNode.parentNode
            service_type = this.getAttribute('data-service-type')
            requestId = this.getAttribute('data-id')
            openModal()
        });

    })

    $(document).on("click", "#confirm_delete", function() {

        $.ajax({
            type: "GET",
            url: baseUrl + "/service-request-status?type=" + type + "&id=" + requestId + "&service_type=" + service_type,

            dataType: "json",

            success: function(response) {
                if (response.status > 0) {

                    data = response.data
                    if (data) {
                        window.location.href = data;
                        return;
                    } else {
                        div.remove();
                        closeModal();
                        not(response.message, "success");
                        return;
                    }

                } else {
                    not(response.message, "error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Error handling for bad requests
                response = jqXHR;
                jsonResp = response?.responseJSON?.message;


                if (response.status == 400) {
                    div.remove();
                    closeModal();
                    not(jsonResp, 'error');
                } else {
                    // not(jsonResp,'error');
                    console.log('Error:', textStatus, errorThrown, response);
                }
            }
        });
    });
    var modal = document.getElementById('Deletemodal');

    function openModal() {
        modal.style.display = "block";
        modal.classList.add("show");
        modal.setAttribute("aria-modal", "true");
        modal.setAttribute("role", "dialog");
    }

    function closeModal() {
        modal.style.display = "none";
        modal.classList.remove("show");
        modal.removeAttribute("aria-modal", "true");
        modal.removeAttribute("role", "dialog");
    }

    $(document).on("click", ".closeModal", () => {
        closeModal();
    });
</script>

@endpush
@stack('scripts')