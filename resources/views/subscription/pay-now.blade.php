<!DOCTYPE html>
<html>

<head>
    <!-- META TAGS-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
    <!-- META TAGS-->
    <title>Card - {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" />

    <!-- BOOTSTRAP 5 -->
    <link rel="stylesheet" href="{{ asset('service_provider_assets/css/bootstrap.min.css') }}" />
    <!-- BOOTSTRAP 5 -->

    <!-- RESPONSIVE NAVIFATION -->
    <link rel="stylesheet" href="{{ asset('service_provider_assets/css/stellarnav.min.css') }}" />
    <!-- RESPONSIVE NAVIFATION -->

    <!-- SWIPER SLIDER -->
    <link rel="stylesheet" href="{{ asset('service_provider_assets/css/swiper-bundle.min.css') }}">
    <!-- SWIPER SLIDER -->

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <!-- GOOGLE FONTS -->

    <!-- FANCY BOX IMAGE VIEWER -->
    <link rel="stylesheet" href="{{ asset('service_provider_assets/css/jquery.fancybox.min.css') }}" />
    <!-- FANCY BOX IMAGE VIEWER -->

    <!-- FONT AWESOME -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    </li>
    <!-- FONT AWESOME -->

    <!-- STYLE SHEETS -->
    <link rel="stylesheet" href="{{ asset('service_provider_assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('service_provider_assets/css/responsive.css') }}" />
    <!-- STYLE SHEETS -->

    <!-- Notification -->
    <link rel="stylesheet" href="{{ asset('assets/notification/css/jquery.growl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/notification/css/notifIt.css') }}">
</head>

<body>
    <div class="fadeWrap"></div>
    <section class="gen-section">
        <div class="gen-wrap">
            <div class="tab-pane show" id="pills-service2" role="tabpanel">
                <div class="row" style="flex-direction: column;justify-content: center;align-items: center;">
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
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="myAccbox myAccbox2">
                            <div id="card-lid">
                                <span>&nbsp;<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                            </div>
                            <button type="button" class="genBtn type2 d-none" id="pay-now-btn">
                                Pay Now
                                <span id="spp-spiner" class="d-none">&nbsp;<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>


    @if(Session::has('success')) <input type="hidden" id="mSg" color="success" value="{{ Session::get('success') }}"> @endif
    @if(Session::has('error')) <input type="hidden" id="mSg" color="error" value="{{ Session::get('error') }}"> @endif
    <input type="hidden" id="baseUrl" value="{{ url('/') }}" />
    <script src="{{ asset('service_provider_assets/js/bootstrap.min.js') }}"></script>
    <!-- BOOTSTRAP 5 -->

    <!-- JQUERY  -->
    <script src="{{ asset('service_provider_assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- JQUERY  -->

    <!-- RESPONSIVE NAVIFATION -->
    <script src="{{ asset('service_provider_assets/js/stellarnav.min.js') }}"></script>
    <!-- RESPONSIVE NAVIFATION -->

    <!-- SWIPER SLIDER -->
    <script src="{{ asset('service_provider_assets/js/swiper-bundle.min.js') }}"></script>
    <!-- SWIPER SLIDER -->

    <!-- FANCY BOX IMAGE VIEWER -->
    <script src="{{ asset('service_provider_assets/js/jquery.fancybox.min.js') }}"></script>
    <!-- FANCY BOX IMAGE VIEWER -->

    <!-- JAVASCRIPT SHEETS -->
    <script src="{{ asset('service_provider_assets/js/calen.js') }}"></script>
    <script src="{{ asset('service_provider_assets/js/custom.js') }}"></script>
    <!-- JAVASCRIPT SHEETS -->




    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk&callback=initAutocomplete&libraries=places&v=weekly" defer></script>

    @stack('scripts')

    <!-- Notification -->
    <script src="{{ asset('assets/notification/js/jquery.growl.js') }}"></script>
    <script src="{{ asset('assets/notification/js/notifIt.js') }}"></script>
    <script src="{{ asset('assets/notification/js/rainbow.js') }}"></script>
    <script src="{{ asset('assets/notification/js/sample.js') }}"></script>

    <script>
        $(document).ready(function() {
            var msg = $('#mSg').val();
            var color = $('#mSg').attr('color');
            if (msg) {
                not(msg, color);
            }
        });

        /** Show notification */
        function not(message, color) {
            notif({
                msg: message,
                type: color
            });
        }


        var baseUrl = $('#baseUrl').val();
    </script>

    <script>
        $(document).ready(function() {
            getCards();
        });
        var imageBaseUrl = $('#baseUrl').val();

        var ccNumberInput = document.querySelector('.cc-number-input'),
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
                    if (i !== 0 && i % limit === 0) {
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

                if (newValue.match(ccNumberPattern)) {
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
                    if (ccCardTypePatterns[cardType].test(ccValue)) {
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
                if (newValue.match(ccExpiryPattern)) {
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



        var cardNumber = document.querySelector('input[name="card_number"]');
        var expiry_month_year = document.querySelector(
            'input[name="expiry_month_year"]'
        );
        $(document).on("click", "#add-card-btn", function(e) {
            e.preventDefault();
            var cardHolderName = document
                .querySelector('input[name="card_holder_name"]')
                .value.trim();

            var cvc = document.querySelector('input[name="cvc"]').value.trim();
            if (cardHolderName === "") {
                not("Card Holder Name can not be empty", "error");
                return;
            }

            if (cardNumber.value.length < 13 || cardNumber.value.length > 19) {
                not("Please provide a valid card number", "error");

                return false;
            }

            if (!expiry_month_year.value) {
                not("Expiry date can not be empty", "error");
                return;
            }

            if (
                expiry_month_year.value.length < 5 ||
                expiry_month_year.value.length > 5
            ) {
                not("Please provide a valid expiry date", "error");
                return;
            }

            if (!cvc) {
                not("Cvc can not be empty", "error");
                return;
            }

            $("#sp-spiner").removeClass("d-none");
            $("#add-card-btn").prop("disabled", true);
            $.post(
                baseUrl + "/add-card",
                $("#add-card-form").serialize(),
                function(response) {
                    $("#sp-spiner").addClass("d-none");
                    $("#add-card-btn").prop("disabled", false);
                    if (response.status > 0) {
                        $("#add-card-form")[0].reset();
                        not(response.message, "success");

                        getCards();
                    } else {
                        not(response.message, "error");
                    }
                },
                "json"
            );
        });


        /** Get Cards */
        function getCards() {
            $.get(
                baseUrl + "/get-cards",
                function(response) {
                    if (response.data.length > 0) {
                        $("#card-lid").html("");
                        $.each(response.data, function(index, val) {
                            var card = 
                                `<div class="paymentWrap mb-3">
                                    <div class="cardAdded">
                                        <input type="radio" class="set-as-default" title="Set as Default" name="is_default" ${index == 0 ? "checked" :""} value="${val.id}" style="margin-right: 10px">
                                        <img src="${ imageBaseUrl + "/assets/images/cr-card-1.png" }" alt="img">
                                        <p class="cNumber"><span>**** **** ****</span> ${ val.last4 }  </p>
                                    </div>
                                    <button class="dltCard xy-center">
                                        <img src="${ imageBaseUrl + "/assets/images/dlt-icon.png" }" alt="img" class="delete-card-btn" data-id="${ val.id }">
                                        <span id="spd-spiner" class="d-none">&nbsp;<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                                    </button>
                                </div>`;

                                $("#card-lid").append(card);
                        });
                        $('#pay-now-btn').removeClass('d-none');
                    } else {
                        $("#card-lid").html(
                            `<div class="paymentWrap mb-3">
                                <div class="cardAdded">
                                    <p class="cNumber"><span>Card not found.</span> </p>
                                </div>
                            </div>`
                        );
                        $('#pay-now-btn').addClass('d-none');
                    }
                },
                "json"
            );
        }

        /** Delete card */
        $(document).on("click", ".delete-card-btn", function() {
            var card_id = $(this).attr("data-id");
            var dir = $(this);
            dir.next().removeClass("d-none");
            $(".delete-card-btn").prop("disabled", true);

            $.get( baseUrl + "/delete-card", {card_id: card_id}, function(response) {
                dir.next().addClass("d-none");
                $(".delete-card-btn").prop("disabled", false);
                if (response.status > 0) {
                    getCards();
                    not(response.message, "success");
                } else {
                    not(response.message, "error");
                }
            }, "json");
        });

        /** Set as default */
        $(document).on('change', '.set-as-default', function () {
            var card_id = $(this).attr('value');
            $.get(baseUrl + '/set-as-default', {card_id:card_id}, function (response) {
                if (response.status > 0) {
                    getCards();
                    not(response.message, "success");
                } 
                else{
                    not(response.message, 'error');
                }
            }, 'json');
        });

        /** Pay now */
        $(document).on('click', '#pay-now-btn', function () {
            $('#spp-spiner').removeClass('d-none');
            $('#pay-now-btn').prop('disabled', true);
            $.post(baseUrl + '/pay-now', {"_token":"{{ csrf_token() }}"}, function (response) {
                if (response.status > 0) {
                    window.location.href = baseUrl;
                } 
                else{
                    $('#sp-spiner').addClass('d-none');
                    $('#pay-now-btn').prop('disabled', false);
                    not(response.message, 'error');
                }

            }, 'json');
        });
    </script>

</body>

</html>