var baseUrl = document.getElementById("baseUrl").value + "/service";

var imageBaseUrl = $('#baseUrl').val();

// Google map
var autocomplete;
var address1Field;
var address2Field;
var postalField;

var phone_number_id = "";

function initAutocomplete() {
    address1Field = document.querySelector("#location");
    address2Field = document.querySelector("#address2");
    postalField = document.querySelector("#postcode");

    autocomplete = new google.maps.places.Autocomplete(address1Field, {
        fields: ["address_components", "geometry"],
        types: ["address"],
    });
    address1Field.focus();
    autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
    const place = autocomplete.getPlace();
    let address1 = "";
    let postcode = "";

    const latitude = place.geometry.location.lat();
    const longitude = place.geometry.location.lng();

    document.querySelector("#latitude").value = latitude;
    document.querySelector("#longitude").value = longitude;

    for (const component of place.address_components) {
        const componentType = component.types[0];

        switch (componentType) {
            case "street_number": {
                address1 = `${component.long_name} ${address1}`;
                break;
            }

            case "route": {
                address1 += component.short_name;
                break;
            }

            case "postal_code": {
                postcode = `${component.long_name}${postcode}`;
                break;
            }

            case "postal_code_suffix": {
                postcode = `${postcode}-${component.long_name}`;
                break;
            }
            case "locality":
                document.querySelector("#city").value = component.long_name;
                break;
            case "administrative_area_level_1": {
                document.querySelector("#state").value = component.short_name;
                break;
            }
            case "country":
                document.querySelector("#country").value = component.long_name;
                break;
        }
    }
    address1Field.value = address1;
    postalField.value = postcode;
    address2Field.focus();
}
window.initAutocomplete = initAutocomplete;
// End google map

//
form_button = document.getElementById("profile_button");
form_button.addEventListener("click", function (event) {
    event.preventDefault();
    var first_name = document.querySelector('input[name="first_name"]').value;
    var last_name = document.querySelector('input[name="last_name"]').value;
    var phone_number = document.querySelector(
        'input[name="phone_number"]'
    ).value;
    var location = document.querySelector('input[name="location"]').value;
    var state = document.querySelector('input[name="state"]').value;
    var city = document.querySelector('input[name="city"]').value;

    if (!first_name) {
        not("First Name field is required", "error");
        return;
    } else if (!last_name) {
        not("First Name field is required", "error");
        return;
    } else if (!phone_number) {
        not("Phone Number field is required", "error");
        return;
    } else if (!location) {
        not("Location field is required", "error");
        return;
    } else if (!state) {
        not("State field is required", "error");
        return;
    } else if (!city) {
        not("City field is required", "error");
        return;
    }

    form = document.getElementById("profile_form");
    $.ajax({
        type: "POST",
        url: baseUrl + "/complete-profile",
        data: new FormData(form),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status > 0) {
                // location.reload();
                console.log(response.data)
                window.location.href = response.data;
                return;
                // not(response.message, "success");
            } else {
                not(response.message, "error");
            }
        },
    });
});
//

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

$(document).ready(function () {
    getCards();
});

/** Add card */
var cardNumber = document.querySelector('input[name="card_number"]');
// cardNumber.addEventListener("input", function () {
//     var cleanedValue = cardNumber.value.replace(/\D/g, "");

//     var maxLength = 19;
//     var truncatedValue = cleanedValue.slice(0, maxLength);
//     cardNumber.value = truncatedValue;
//     // cardNumber.value = cleanedValue;
// });

var expiry_month_year = document.querySelector(
    'input[name="expiry_month_year"]'
);

// expiry_month_year.addEventListener("input", function () {
//     var value = expiry_month_year.value;

//     // Remove any non-digit characters
//     var cleanedValue = value.replace(/\D/g, "");

//     // Insert the slash after the first two digits
//     if (cleanedValue.length > 2) {
//         cleanedValue = cleanedValue.slice(0, 2) + "/" + cleanedValue.slice(2);
//     }

//     // Restrict input to only four digits after the slash
//     if (cleanedValue.length > 5) {
//         cleanedValue = cleanedValue.slice(0, 5);
//     }

//     // Update the input value
//     expiry_month_year.value = cleanedValue;
// });

$(document).on("click", "#add-card-btn", function (e) {
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
        function (response) {
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
        function (response) {
            // console.log('response **/ ', response);
            if (response.data.length > 0) {
                $("#card-lid").html("");
                $.each(response.data, function (index, val) {
                    var card = `<div class="paymentWrap mb-3">
                                <div class="cardAdded">
                                    <img src="${
                                        imageBaseUrl +
                                        "/assets/images/cr-card-1.png"
                                    }" alt="img">
                                    <p class="cNumber"><span>**** **** ****</span> ${
                                        val.last4
                                    }  </p>
                                </div>
                                <button class="dltCard xy-center">
                                    <img src="${
                                        imageBaseUrl +
                                        "/assets/images/dlt-icon.png"
                                    }" alt="img" class="delete-card-btn" data-id="${
                        val.id
                    }">
                                    <span id="spd-spiner" class="d-none">&nbsp;<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                                </button>
                            </div>`;

                    $("#card-lid").append(card);
                });
            } else {
                $("#card-lid").html(
                    `<div class="paymentWrap mb-3">
                    <div class="cardAdded">
                        <p class="cNumber"><span>Card not found.</span> </p>
                    </div>
                </div>`
                );
            }
        },
        "json"
    );
}

/** Delete card */
$(document).on("click", ".delete-card-btn", function () {
    var card_id = $(this).attr("data-id");
    var dir = $(this);

    $("#spd-spiner").removeClass("d-none");
    $(".delete-card-btn").prop("disabled", true);

    $.get(
        baseUrl + "/delete-card",
        { card_id: card_id },
        function (response) {
            $("#spd-spiner").addClass("d-none");
            $(".delete-card-btn").prop("disabled", false);
            if (response.status > 0) {
                dir.parent().parent().remove();
                not(response.message, "success");
            } else {
                not(response.message, "error");
            }
        },
        "json"
    );
});
