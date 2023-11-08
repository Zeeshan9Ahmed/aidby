@extends('user.layouts.master')
@section('title', 'Complete profile')
@section('content')

<section class="gen-section">
    <div class="gen-wrap">
        <div class="topHeading d-flex align-items-center pb-5">
            <h1 class="headingMain ms-3">Settings</h1>
        </div>

        <div class="serviceBox1 settingBox serviceSetting">
            <ul class="nav nav-pills mb-5 serviceTab settingTab" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-service1-tab" data-bs-toggle="pill" data-bs-target="#pills-service1" type="button" role="tab"> Profile Setting</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-service2-tab" data-bs-toggle="pill" data-bs-target="#pills-service2" type="button" role="tab">My Account</button>
                <!-- </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-service5-tab" data-bs-toggle="pill" data-bs-target="#pills-service5" type="button" role="tab">Liability Insurance</button>
                </li> -->
                <li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-service6-tab" data-bs-toggle="pill" data-bs-target="#pills-service6" type="button" role="tab">Emergency Contacts</button>
				</li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <!-- Profile setting -->
                <div class="tab-pane fade show active" id="pills-service1" role="tabpanel">
                    <form class="row settingForm" id="complete-profile-form"> @csrf
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="avatar-upload">
                                <div class="avatar-edit">
                                    <input type="file" id="imageUpload" accept=".png, .jpg, .jpeg" name="profile_image">
                                    <label for="imageUpload" class="xy-center">
                                        <img src="{{ asset('assets/images/upload.png') }}" alt="img">
                                    </label>
                                </div>
                                <div class="avatar-preview">
                                    @if(auth()->user()->profile_image)
                                    <div id="imagePreview" style="background-image: url({{ asset(auth()->user()->profile_image) }});"> </div>
                                    @else
                                    <div id="imagePreview" style="background-image: url({{ asset('assets/images/user-image.png') }});"> </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group logInput mb-3">
                                        <input type="text" placeholder="First Name" class="input1 ps-4" name="first_name" value="{{ auth()->user()->first_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group logInput mb-3">
                                        <input type="text" placeholder="Last Name" class="input1 ps-4" name="last_name" value="{{ auth()->user()->last_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group logInput mb-3">
                                        <input type="number" placeholder="Phone Number" class="input1 ps-4" name="phone_number" value="{{ auth()->user()->phone_number }}" onKeyPress="if(this.value.length==15) return false;">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group logInput mb-3">
                                        <input type="text" placeholder="Address" class="input1 ps-4" id="location" name="location" value="{{ auth()->user()->location }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group logInput mb-3">
                                        <input type="text" placeholder="State" class="input1 ps-4" id="state" name="state" value="{{ auth()->user()->state }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                    <div class="form-group logInput mb-3">
                                        <input type="text" placeholder="City" class="input1 ps-4" id="city" name="city" value="{{ auth()->user()->city }}">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <input type="hidden" id="latitude" name="latitude" value="{{ auth()->user()->latitude }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ auth()->user()->longitude }}">
                                    <button class="logBtn mb-3">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- My account -->
                <div class="tab-pane fade" id="pills-service2" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="myAccbox">
                                <div class="paymentWrap mb-3 d-none">
                                    <div class="cardAdded">
                                        <img src="{{ asset('assets/images/cr-card-1.png') }}" alt="img">
                                        <p class="cNumber"><span>*****</span> 5562 12354</p>
                                    </div>
                                    <button class="dltCard xy-center">
                                        <img src="{{ asset('assets/images/dlt-icon.png') }}" alt="img">
                                    </button>
                                </div>

                                <div id="card-lid">

                                </div>

                                <div class="genBar xy-between">
                                    <p class="title pb-2">Subscription</p>
                                </div>
                                <div class="genCard1 d-block subsBox">
                                    <p class="title text-center pb-2">Coming soon</p>

                                    <div class="row d-none">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center">
                                            <ul class="list-unstyled">
                                                <li class="desc pb-2"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
                                                <li class="desc pb-2"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
                                                <li class="desc pb-2"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center">
                                            <ul class="list-unstyled">
                                                <li class="desc pb-2"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
                                                <li class="desc pb-2"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
                                                <li class="desc pb-2"><i class="fa-solid fa-circle-check me-2"></i> Lorem ipsum dolor sit amet</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <button class="genBtn type2 bookBtn d-none" type="button">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="paymentBox">
                                <p class="title text-center pb-2">Add New Card</p>

                                <div class="row mb-3">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                        <label for="payment1" class="paymentType xy-center">
                                            <img src="{{ asset('assets/images/card-type-1.png') }}" alt="img">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="payment1" name="radioCheck" checked>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 d-none">
                                        <label for="payment2" class="paymentType xy-center">
                                            <img src="{{ asset('assets/images/card-type-2.png') }}" alt="img">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" id="payment2" name="radioCheck">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <form id="add-card-form"> @csrf
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group logInput mb-3">
                                                <input type="text" placeholder="Card Holder Name" class="input1 ps-4" name="card_holder_name">
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <div class="form-group logInput mb-3">
                                                <input type="text" placeholder="Card Number" class="input1 ps-4 cc-number-input" name="card_number">
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group logInput mb-3">
                                                <input type="text" placeholder="Expiry Month/Year" class="input1 ps-4 cc-expiry-input" name="expiry_month_year">
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <div class="form-group logInput mb-3">
                                                <input type="text" placeholder="CVV" class="input1 ps-4 cc-cvc-input" name="cvc">
                                            </div>
                                        </div>
    
                                        <div class="col-12">
                                            <button type="button" class="genBtn type2" id="add-card-btn">
                                                Submit
                                                <span id="sp-spiner" class="d-none">&nbsp;<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Liability Insurance -->
                <div class="tab-pane fade" id="pills-service5" role="tabpanel">
                    <div class="noticeBox">
                        <h2>{!! $content[2]->title !!}</h2>
                        <br>
                        {!! $content[2]->content !!}
                    </div>
                </div>
                <!-- Emergency Contacts -->
                <div class="tab-pane fade" id="pills-service6" role="tabpanel">
					<div class="contactBox">
						<div class="noticeBox pt-3 pb-3">
							<textarea disabled id="sos_message">{{ auth()->user()->sos_message }}</textarea>
							<a href="javascript:void(0)" class="editIcon" data-bs-toggle="modal" data-bs-target="#editIconModal"><i class="fa-solid fa-pen-to-square"></i></a>
						</div>

						@if (!$contacts->isEmpty() )

						@foreach ($contacts as $contact)
						<div class="noticeBox mt-3 xy-between">
							<p class="desc numBer">{{ $contact->phone_number }}</p>
							<button class="editBtn1 dltContct clr4" data-id="{{ $contact->id }}" id="deleteNumber"><img src="{{ asset('assets/images/edit-icon-2.png') }}" alt="img"></button>
						</div>
						@endforeach
						@endif

						<input type="hidden" id="_token" value="{{csrf_token()}}">
					</div>
					<div class="contactBox_btnSec">
						<button type="button" class="genBtn xy-center m-0 mb-2" onclick="addSetweek(this)">+ Add</button>
						<button class="genBtn type2 mt-3" id="saveNumber">Save</button>
					</div>
				</div>
            </div>
        </div>
    </div>
</section>

<!--Delete Modal Start-->
<div class="modal fade genModal" id="deletePhoneNumberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<form class="genForm row">
					<div class="col-12">
						<div class="row mb-3">
							<div class="col-12">
								<p class="headingMain text-center pb-3">Do you want to delete this?</p>
							</div>
						</div>
					</div>
					<div class="col-12">
						<button class="genBtn type2" id="delete_number_confirm" type="button">Delete</button>
					</div>
				</form>
				<button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
			</div>
		</div>
	</div>
</div>
<!--Delet Modal End-->

<!--Edit Modal Start-->
<div class="modal fade genModal" id="editIconModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-body">
				<form class="genForm row">
					<div class="col-12">
						<div class="row mb-3">
							<div class="col-12 editBox">
								<div class="noticeBox pt-3 pb-3">
									<textarea id="message"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12">
						<button class="genBtn type2" id="save_sos_message" type="button">Save</button>
					</div>
				</form>
				<button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
			</div>
		</div>
	</div>
</div>

@endsection
@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
<script src="{{ asset('assets/js/custom/user/profile.js') }}"></script>

<script>
    let ccNumberInput = document.querySelector('.cc-number-input'),
		ccNumberPattern = /^\d{0,16}$/g,
		ccNumberSeparator = " ",
		ccNumberInputOldValue,
		ccNumberInputOldCursor,
		
		ccExpiryInput = document.querySelector('.cc-expiry-input'),
		ccExpiryPattern = /^\d{0,4}$/g,
		ccExpirySeparator = "/",
		ccExpiryInputOldValue,
		ccExpiryInputOldCursor,
		
		ccCVCInput = document.querySelector('.cc-cvc-input'),
		ccCVCPattern = /^\d{0,4}$/g,
		
		mask = (value, limit, separator) => {
			var output = [];
			for (let i = 0; i < value.length; i++) {
				if ( i !== 0 && i % limit === 0) {
					output.push(separator);
				}
				
				output.push(value[i]);
			}
			
			return output.join("");
		},
		unmask = (value) => value.replace(/[^\d]/g, ''),
		checkSeparator = (position, interval) => Math.floor(position / (interval + 1)),
		ccNumberInputKeyDownHandler = (e) => {
			let el = e.target;
			ccNumberInputOldValue = el.value;
			ccNumberInputOldCursor = el.selectionEnd;
		},
		ccNumberInputInputHandler = (e) => {
			let el = e.target,
					newValue = unmask(el.value),
					newCursorPosition;
			
			if ( newValue.match(ccNumberPattern) ) {
				newValue = mask(newValue, 4, ccNumberSeparator);
				
				newCursorPosition = 
					ccNumberInputOldCursor - checkSeparator(ccNumberInputOldCursor, 4) + 
					checkSeparator(ccNumberInputOldCursor + (newValue.length - ccNumberInputOldValue.length), 4) + 
					(unmask(newValue).length - unmask(ccNumberInputOldValue).length);
				
				el.value = (newValue !== "") ? newValue : "";
			} else {
				el.value = ccNumberInputOldValue;
				newCursorPosition = ccNumberInputOldCursor;
			}
			
			el.setSelectionRange(newCursorPosition, newCursorPosition);
			
			highlightCC(el.value);
		},
		highlightCC = (ccValue) => {
			let ccCardType = '',
					ccCardTypePatterns = {
						amex: /^3/,
						visa: /^4/,
						mastercard: /^5/,
						disc: /^6/,
						
						genric: /(^1|^2|^7|^8|^9|^0)/,
					};
			
			for (const cardType in ccCardTypePatterns) {
				if ( ccCardTypePatterns[cardType].test(ccValue) ) {
					ccCardType = cardType;
					break;
				}
			}
			
			let activeCC = document.querySelector('.cc-types__img--active'),
					newActiveCC = document.querySelector(`.cc-types__img--${ccCardType}`);
			
			if (activeCC) activeCC.classList.remove('cc-types__img--active');
			if (newActiveCC) newActiveCC.classList.add('cc-types__img--active');
		},
		ccExpiryInputKeyDownHandler = (e) => {
			let el = e.target;
			ccExpiryInputOldValue = el.value;
			ccExpiryInputOldCursor = el.selectionEnd;
		},
		ccExpiryInputInputHandler = (e) => {
			let el = e.target,
					newValue = el.value;
			
			newValue = unmask(newValue);
			if ( newValue.match(ccExpiryPattern) ) {
				newValue = mask(newValue, 2, ccExpirySeparator);
				el.value = newValue;
			} else {
				el.value = ccExpiryInputOldValue;
			}
		};

    ccNumberInput.addEventListener('keydown', ccNumberInputKeyDownHandler);
    ccNumberInput.addEventListener('input', ccNumberInputInputHandler);

    ccExpiryInput.addEventListener('keydown', ccExpiryInputKeyDownHandler);
    ccExpiryInput.addEventListener('input', ccExpiryInputInputHandler);

    $(document).on('click', '.editIcon', function() {
		var message = $('#sos_message').val();
		$('#message').val(message)
	});

    var basePath = $("#baseUrl").val();
    function addSetweek(button) {
        imagePath = `${basePath}/assets/images/edit-icon-2.png`;
        
        
        let exercise = button.parentNode.parentNode;
        let sets = exercise.querySelector(".contactBox");
        let setCount = sets.childElementCount + 1;
        
        let newSet = document.createElement("div");
        newSet.classList.add("noticeBox",'inputDiv','mt-3','xy-between');
        // newSet.setAttribute('id','inputDiv');
        newSet.innerHTML = `
            <input type="text" class="phNumber" name="phone_number[]" placeholder="Emergency Contact Number">
            <button class="editBtn1 dltContct clr4" id="deleteTempNumber"><img src="${imagePath}" alt="img"></button>

        `;
        sets.appendChild(newSet);
    }

	$(document).on('click', '#save_sos_message', function() {
		var message = $('#message').val();
		if (!message) {
			not('Message field can not be empty', 'error');
			return;
		}

		$.get(baseUrl + "/save-sos_message?message=" + message, function(response) {
				$('#sos_message').val(message);
				$('.closeModal').trigger('click');
        }, "json");
    });

    $(document).on("click", "#saveNumber", function () {
        var inputs = document.getElementsByClassName("phNumber");
        if (inputs.length == 0) {
            not("Please add new field to save number", "error");
            return;
        }

        var formData = new FormData();

        for (var i = 0; i < inputs.length; i++) {
            var input = inputs[i];

            // Perform operations on each input element
            if (input.value == "") {
                not("Please fill all fields", "error");
                return;
            }
            formData.append(input.name, input.value);
        }

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $("#_token").val(),
            },
        });

        $.ajax({
            type: "POST",
            url: baseUrl + "/save-contacts",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                if (response.status > 0) {
                    var ids = response.data;
                    
                    var divs = document.querySelectorAll(".inputDiv.mt-3");

                    for (var i = 0; i < divs.length; i++) {
                        var div = divs[i];
                        div.classList.remove('mt-3');
                        var input = div.querySelector("input");
                        var button = div.querySelector("button");
                        
                        if (input) {
                            var paragraph = document.createElement("p");
                            paragraph.textContent = input.value;
                            div.replaceChild(paragraph, input);

                            button.id = "deleteNumber";
                            button.setAttribute("data-id", ids[i]);
                        }
                        
                    }
                    
                    not(response.message, "success");
                } else {
                    not(response.message, "error");
                }
            },
        });
    });

    phone_modal = document.getElementById("deletePhoneNumberModal");
    contact_div_ref = "";
    $(document).on("click", "#deleteNumber", function () {
        ref = $(this)[0];
        contact_div_ref = ref.offsetParent;

        phone_number_id = ref.getAttribute("data-id");
        phone_modal.style.display = "block";
        phone_modal.classList.add("show");
        phone_modal.setAttribute("aria-modal", "true");
        phone_modal.setAttribute("role", "dialog");
    });

    $(document).on("click", ".closeModal", () => {
        phone_modal.style.display = "none";
        phone_modal.classList.remove("show");
        phone_modal.removeAttribute("aria-modal", "true");
        phone_modal.removeAttribute("role", "dialog");
    });

    $(document).on("click", "#delete_number_confirm", function () {
        $.ajax({
            type: "GET",
            url: baseUrl + "/delete-contact?id=" + phone_number_id,

            dataType: "json",

            success: function (response) {
                if (response.status > 0) {
                    contact_div_ref.remove();

                    phone_modal.style.display = "none";
                    phone_modal.classList.remove("show");
                    phone_modal.removeAttribute("aria-modal", "true");
                    phone_modal.removeAttribute("role", "dialog");
                    not(response.message, "success");
                } else {
                    not(response.message, "error");
                }
            },
        });
    });

    $(document).on("click", "#deleteTempNumber", function () {
        $(this)[0].offsetParent.remove();
    });
</script>

@endpush