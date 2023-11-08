@extends('user.layouts.master')
@section('title', 'Book service')
@section('content')
<style>
    .pac-container {
        z-index: 100000 !important;
    }
</style>
<section class="gen-section">
    <div class="gen-wrap">
        <div class="topHeading d-flex align-items-center pb-5">
            <h1 class="headingMain ms-3">Book Service</h1>
        </div>
        <form id="book-service-form"> @csrf
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="serviceBox1">
                        <div class="genBar xy-between">
                            <p class="title">Select Date and Time</p>
                            <p class="date"><span><img src="{{ asset('assets/images/nav-icon-2.png') }}" alt="img" class="me-2"></span> </p>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Start date" onfocus="(this.type='date')" class="genInput mb-2" name="start_date" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="End date" onfocus="(this.type='date')" class="genInput mb-2" name="end_date" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <input type="text" placeholder="Select Time" onfocus="(this.type='time')" class="genInput mb-2" name="time" required>
                                </div>
                            </div>
                        </div>

                        <div class="genBar xy-between">
                            <p class="title pb-2">Provider</p>
                        </div>

                        <div class="genCard1">
                            <div class="imgBox">
                                @if(!empty($service->service_provider->profile_image))
                                <img src="{{ asset($service->service_provider->profile_image) }}" alt="img" class="userImg">
                                @else
                                <img src="{{ asset('assets/images/user-image.png') }}" alt="img" class="userImg">
                                @endif
                            </div>
                            <div class="textBox">
                                <div class="genBar xy-between">
                                    <div class="leftCol d-flex align-items-center">
                                        <p class="title me-3">{{ $service->service_provider->first_name }} {{ $service->service_provider->last_name }}</p>
                                    </div>
                                    <p class="price"><span>$</span>{{ number_format($service->fixed_price) }}</p>
                                </div>
                                <p class="desc"> {{ $service->description }} </p>
                            </div>
                        </div>
                        <div class="genBar xy-between pb-2">
                            <p class="title">Payment Method</p>
                            <a href="{{ url('user/complete-profile') }}" class="title addCard">Add Card</a>
                        </div>
                        <div class="form-group mb-3">
                            <label for="radio1" class="xy-between genInput">
                                <span>Cash</span>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="radio1" name="payment_method" value="cash" required>
                                </div>
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="radio2" class="xy-between genInput">
                                <span>Card</span>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="radio2" name="payment_method" value="card" required>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12 col-12">
                    <div class="serviceBox1">
                        <div class="genBar xy-between pb-3">
                            <p class="title">Address</p>
                            <a href="#addAdress" data-bs-toggle="modal" class="title addCard">Add New Address</a>
                        </div>
                        <div class="genCard1 addressCard1" id="address-card">
                            <p class="desc">Address: <span>{{ auth()->user()->location }}</span></p>
                            <p class="desc">City: <span>{{ auth()->user()->city }}</span></p>
                            <p class="desc">State: <span>{{ auth()->user()->state }}</span></p>
                        </div>

                        <div class="genBar xy-between pb-2">
                            <p class="title">Billing</p>
                        </div>
                        <div class="genCard1 addressCard1">
                            <div class="fig xy-between">
                                <p class="desc">Amount</p>
                                <span class="amount">${{ number_format($service->fixed_price) }}</span>
                            </div>
                            <div class="fig type2 xy-between pt-3">
                                <p class="desc">Total Amount</p>
                                <span class="amount">${{ number_format($service->fixed_price) }}</span>
                            </div>
                        </div>

                        <div class="genBar xy-between pb-2">
                            <p class="title">Problem Image</p>
                        </div>
                        <div class="uploadBox">
                            <label id="wrapper" for="fileUpload" class="xy-center">
                                <img src="{{ asset('assets/images/uploadIcon.png') }}" alt="img">
                                <p class="pt-2">Upload Image</p>
                                <input id="fileUpload" class="d-none" type="file" name="images[]" multiple accept="image/gif, image/jpeg, image/png" />
                            </label>
                            <button type="button" class="clearBtn xy-center d-none">Clear All</button>
                        </div>
                        <div id="image-holder" class="pb-2"></div>

                        <div class="genBar xy-between pb-2">
                            <p class="title">Additional Information</p>
                        </div>
                        <textarea class="genInput infoText" name="additional_information" required></textarea>
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="is_other_address" id="is_other_address" value="0">
                        <input type="hidden" name="other_state" id="state">
                        <input type="hidden" name="other_city" id="city">
                        <input type="hidden" name="other_address" id="other_address">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <button class="genBtn sendBtn" id="book-service-btn">
                            Send Request
                            <span id="sp-spiner" class="d-none">&nbsp;<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Add New Address Modal Start-->
<div class="modal fade genModal" id="addAdress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="headingMain text-center pb-3 pt-4">Add New Address</p>
                <form class="genForm row" id="manually-address">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <button class="genBtn mb-3" type="button">Add Manually</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <button class="genBtn liveLocbtn mb-3" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#mapModal">Live Location</button>
                    </div>
                    <div class="col-12">
                        <div class="form-group logInput mb-3">
                            <input type="text" placeholder="Address" id="input-other-address" class="input1 ps-4">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group logInput mb-3">
                            <input type="text" placeholder="City" id="input-other-city" class="input1 ps-4">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group logInput mb-3">
                            <input type="text" placeholder="State" id="input-other-state" class="input1 ps-4">
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="genBtn" type="button" id="add-new-address-btn">Submit</button>
                    </div>
                </form>
                <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
<!--Add New Address Modal End-->

<!-- Add New Address Map Modal Start-->
<div class="modal fade genModal" id="mapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <p class="headingMain text-center pb-3 pt-4">Add New Address</p>
                <form class="genForm row" id="live-address">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <button class="genBtn liveLocbtn mb-3 mb-3" type="button" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#addAdress">Add Manually</button>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <button class="genBtn" type="button">Live Location</button>
                    </div>
                    <div class="col-12">
                        <div class="form-group logInput mb-3">
                            <input type="text" placeholder="Search location" class="input1 ps-4" id="location" readonly>
                            <img src="{{ asset('assets/images/location.png') }}" alt="img" class="logIcon type2" onclick="getLocation()">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mapouter mb-3">
                            <div id="map-s">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="genBtn" type="button" id="select-live-location">Select</button>
                    </div>
                </form>
                <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
<!--Add New Address Map Modal End-->
@endsection
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk"></script>

<script src="{{ asset('assets/js/custom/user/profile.js') }}"></script>

<script>
    var map = new google.maps.Map(document.getElementById("map-s"), {
        zoom: 1,
        center: new google.maps.LatLng(44.000000, -72.699997),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

    function showPosition(position) {
        codeLatLng(position.coords.latitude, position.coords.longitude);

        let marker = new google.maps.Marker({
            position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
            map: map
        });
    }

    function codeLatLng(lat, lng) {
        geocoder = new google.maps.Geocoder();

        var latlng = new google.maps.LatLng(lat, lng);

        geocoder.geocode({
            'latLng': latlng
        }, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    var indice = 0;
                    for (var j = 0; j < results.length; j++) {
                        if (results[j].types[0] == 'locality') {
                            indice = j;
                            break;
                        }
                    }
                    // alert('The good number is: ' + j);
                    // console.log(results[0].formatted_address);
                    for (var i = 0; i < results[j].address_components.length; i++) {
                        if (results[j].address_components[i].types[0] == "locality") {
                            city = results[j].address_components[i];
                        }
                        if (results[j].address_components[i].types[0] == "administrative_area_level_1") {
                            region = results[j].address_components[i];
                        }
                        if (results[j].address_components[i].types[0] == "country") {
                            country = results[j].address_components[i];
                        }
                    }

                    $('#address-card').html(
                        `<p class="desc">Address: <span>${ results[0].formatted_address }</span></p>
                        <p class="desc">City: <span>${ city.long_name }</span></p>
                        <p class="desc">State: <span>${ region.long_name }</span></p>
                        `
                    );

                    $('#latitude').val(lat);
                    $('#longitude').val(lng);
                    $('#city').val(city.long_name);
                    $('#address').val(results[0].formatted_address);
                    $('#location').val(results[0].formatted_address)
                }
            } 
        });
    }
</script>
@endpush