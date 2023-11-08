var baseUrl = document.getElementById("baseUrl").value + "/service";
console.log(baseUrl, "baseUrl");
var modal = document.getElementById("Deletemodal");
var deleteServiceButton = document.getElementById('deleteService');
var basePath = $("#baseUrl").val();
var generateServiceCard = (service) => {
    image_url = service.service_provider.profile_image;
    return `<div class="col-lg-4 col-md-4 col-sm-6 col-12 service_container" data-id="${
        service?.id
    }">
    <label for="post1" class="postLabel genCard1 align-items-center">
        <div class="imgBox">
        <img src="${
            image_url
                ? `${basePath}/${image_url}`
                : `${basePath}/assets/images/mem1.png`
        }" alt="img">
        </div>
        <div class="textBox">
            <div class="topBar xy-between">
                <div class="leftCol d-flex align-items-center">
                    <p class="title me-3">${
                        service.service_sub_category.title
                    }</p>
                </div>
            </div>
            <div class="xy-between pt-2 pb-2 pe-4">
                <p class="desc"><strong>Fixed Price: $${service.fixed_price}</strong></p>
                </div>
                <p class="desc reque-text">
                ${service.description}
                </p>
                </div>
                <div class="form-check postedCheck">
                <input class="form-check-input" type="checkbox" id="post1" value="${
                    service?.id
                }">
                </div>
                </label>
                </div>`;
};
if (services.length == 0 ) {
    deleteServiceButton.style.display = "none";
}
cards = services
    .map((service) => {
        return generateServiceCard(service);
    })
    .join("");
function loadCardsHtml(cards) {
    var ele = document.getElementById("deleteService");
    var fragment = document.createRange().createContextualFragment(cards);
    ele.parentNode.insertBefore(fragment, ele.nextSibling);
}
loadCardsHtml(cards?cards:`<p class="noData">Data not found</p>`);
$(document).on("click", "#service_button", function (e) {
    e.preventDefault();
    var category_id = document.getElementById("category_id").value;
    var sub_category_id = document.getElementById("sub_category_id").value;
    var fixed_price = document.getElementById("fixed_price").value;
    // var per_hour_rate = document.getElementById("per_hour_rate").value;
    var description = document.getElementById("description").value;
    var license = document.getElementsByName("license");
    if (!category_id) {
        not("Please Select A Category", "error");
        return;
    } else if (!sub_category_id) {
        not("Please Select A Sub Category", "error");
        return;
    } else if (!fixed_price) {
        not("Fixed Price can not be empty", "error");
        return;
    }
    // else if (!per_hour_rate) {
    //     not("Hourly Rate can not be empty", "error");
    //     return;
    // }
     else if (!description) {
        not("Description can not be empty", "error");
        return;
    }
    var form = document.getElementById("service_form");
    var modal = document.getElementById("addServie");
    $.ajax({
        type: "POST",
        url: baseUrl + "/service",
        data: new FormData(form),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status > 0) {
                location.reload();
                // not(response.message, "success");
            } else {
                not(response.message, "error");
            }
        },
    });
});
var fixed_price = document.getElementById("fixed_price");
fixed_price.addEventListener("input", function (event) {
    var value = event.target.value;
    // Remove any non-numeric or non-decimal characters
    value = value.replace(/[^0-9.]/g, "");
    // Ensure there's only one decimal point
    value = value.replace(/(\..*)\./g, "$1");
    // Update the input value
    event.target.value = value;
});
// var per_hour_rate = document.getElementById("per_hour_rate");
// per_hour_rate.addEventListener("input", function (event) {
//     var value = event.target.value;
//     // Remove any non-numeric or non-decimal characters
//     value = value.replace(/[^0-9.]/g, "");
//     // Ensure there's only one decimal point
//     value = value.replace(/(\..*)\./g, "$1");
//     // Update the input value
//     event.target.value = value;
// });
services_ids = [];
$(document).on("click", ".form-check-input", function () {
    var checkbox = $(this)[0];
    id = checkbox.value;
    if (checkbox.checked == true) {
        services_ids.push(id);
    } else {
        services_ids = services_ids.filter((e) => e !== id);
    }
});
$(document).on("change", "#category_id", function () {
    var id = $(this).val();
    $.get(
        baseUrl + "/get-sub-categories/" + id,
        function (response) {
            var options =
                '<option value="" selected disabled>-- Sub Category --</option>';
            if (response.length > 0) {
                $.each(response, function (index, data) {
                    options +=
                        '<option value="' +
                        data.id +
                        '">' +
                        data.title +
                        "</option>";
                });
            }
            $("#sub_category_id").html(options);
        },
        "json"
    );
});
// confirm_delete
$(document).on("click", "#confirm_delete", function () {
    var arrayString = JSON.stringify(services_ids);
    // Encode the array string to make it URL-safe
    var encodedArray = encodeURIComponent(arrayString);
    $.ajax({
        type: "GET",
        url: baseUrl + "/delete-services?ids=" + encodedArray,
        dataType: "json",
        success: function (response) {
            if (response.status > 0) {
                $(".service_container")
                    .filter(function () {
                        id = $(this)[0].attributes[1].value;
                        return services_ids.includes(id);
                    })
                    .remove();
                    services = services.filter(function(service) {
                        return !services_ids.includes(String(service.id));
                      });
                if (services.length == 0 ) {
                    loadCardsHtml(`<p class="noData">Data not found</p>`);
                    deleteServiceButton.style.display = "none";
                }
                // services_ids = []
                modal.style.display = "none";
                modal.classList.remove("show");
                modal.removeAttribute("aria-modal", "true");
                modal.removeAttribute("role", "dialog");
                not(response.message, "success");
            } else {
                not(response.message, "error");
            }
        },
    });
});
$(document).on("click", "#deleteService", function () {
    if (services_ids.length == 0) {
        not("Select atleaset one service to delete", "error");
        return;
    }
    modal.style.display = "block";
    modal.classList.add("show");
    modal.setAttribute("aria-modal", "true");
    modal.setAttribute("role", "dialog");
});
// closeModal
$(document).on("click", ".closeModal", () => {
    modal.style.display = "none";
    modal.classList.remove("show");
    modal.removeAttribute("aria-modal", "true");
    modal.removeAttribute("role", "dialog");
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(function (checkbox) {
        checkbox.checked = false;
    });
    services_ids = [];
});