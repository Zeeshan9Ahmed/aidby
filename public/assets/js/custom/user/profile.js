var baseUrl = $('#baseUrl').val() + '/user';
var imageBaseUrl = $('#baseUrl').val();

// Google map
let autocomplete;
let address1Field;
let address2Field;
let postalField;

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
                // document.querySelector("#other_city").value = component.long_name;
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



/** Complete profile */
$("#complete-profile-form").on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: baseUrl + '/complete-profile',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status > 0) {
                window.location.href = baseUrl;
            } else {
                not(response.message, 'error');
            }
        }
    });
});

$(document).ready( function(){
    getCards();
});

/** Add card */
$(document).on('click', '#add-card-btn', function () {
    $('#sp-spiner').removeClass('d-none');
    $('#add-card-btn').prop('disabled', true);
    $.post(baseUrl + '/add-card', $('#add-card-form').serialize(), function (response) {
        $('#sp-spiner').addClass('d-none');
        $('#add-card-btn').prop('disabled', false);
        if (response.status > 0) {
            $('#add-card-form')[0].reset();
            not(response.message, 'success');

            getCards();
        } else{
            not(response.message, 'error');
        }
    }, 'json');
});

/** Get Cards */
function getCards(){
    $.get(baseUrl + '/get-cards', function (response) {
        // console.log('response **/ ', response);
        if (response.data.length > 0) {
            $('#card-lid').html('');
            $.each(response.data, function(index, val) {

                var card = `<div class="paymentWrap mb-3">
                                <div class="cardAdded">
                                    <img src="${ imageBaseUrl + '/assets/images/cr-card-1.png' }" alt="img">
                                    <p class="cNumber"><span>**** **** ****</span> ${val.last4}  </p>
                                </div>
                                <button class="dltCard xy-center">
                                    <img src="${ imageBaseUrl + '/assets/images/dlt-icon.png' }" alt="img" class="delete-card-btn" data-id="${val.id}">
                                    <span id="spd-spiner" class="d-none">&nbsp;<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> </span>
                                </button>
                            </div>`;

                $('#card-lid').append(card);
            });
        } else{
            $('#card-lid').html(
                `<div class="paymentWrap mb-3">
                    <div class="cardAdded">
                        <p class="cNumber"><span>Card not found.</span> </p>
                    </div>
                </div>`);
        }

    }, 'json');
}

/** Delete card */
$(document).on('click', '.delete-card-btn', function () {
    var card_id = $(this).attr('data-id');
    var dir = $(this);

    $('#spd-spiner').removeClass('d-none');
    $('.delete-card-btn').prop('disabled', true);

    $.get(baseUrl + '/delete-card', {card_id:card_id}, function (response) {
        $('#spd-spiner').addClass('d-none');
        $('.delete-card-btn').prop('disabled', false);
        if (response.status > 0) {
            dir.parent().parent().remove();
            not(response.message, 'success');
        } else{
            not(response.message, 'error');
        }
    }, 'json');
});


/** Create review */
$(document).on('click', '.give-review', function () {
    var id = $(this).attr('data-id');
    var type = $(this).attr('data-type');
    var user_service_id = $(this).attr('data-user-service-id');
    $('#type').val(type);
    $('#record_id').val(id);
    $('#user_service_id').val(user_service_id);
    $('#reviewModal').modal('show');
});
