var baseUrl = $('#baseUrl').val() + '/user';
var imageBaseUrl = $('#baseUrl').val();

/** Search */
$('#header-search').keyup( function(e){
    e.preventDefault();
    var search_key = $(this).val();

    $.get(baseUrl + '/search', {search_key:search_key}, function (response) {
        var html = '';
        if (response.status > 0) {
            html += '<ul id="search-list">';
            $.each(response.data, function( index, value ) {
                console.log(value);
                html += `<li class="select-search"><a class="search-ahref" href="${ baseUrl +'/category/'+ value.id }"> ${uppercase(value.title)} </a></li>`;
            });
            html += '</ul>';

            $("#suggesstion-box").show();
            $("#suggesstion-box").html(html);
        } else{
            $("#suggesstion-box").html('');
            $("#suggesstion-box").hide();
            
        }
    }, 'json');
});

/** Get categories */
$(document).ready( function () {
    $.get(baseUrl + '/get-categories/', function (response) {
        var options = '<option value="" selected disabled>-- Category --</option>';
        if (response.length > 0) {
            $.each(response, function (index, data) {
                options += '<option value="' + data.id + '">' + uppercase(data.title) + '</option>';
            })
        }
        $('#categories').html(options);
    }, 'json');
});

/** Get sub categories */
$(document).on('change', '#categories', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var id = $(this).val();
    $.get(baseUrl + '/get-sub-categories/' + id, function (response) {
        var options = '<option value="" selected disabled>-- Sub Category --</option>';
        if (response.length > 0) {
            $.each(response, function (index, data) {
                options += '<option value="' + data.id + '">' + uppercase(data.title) + '</option>';
            })
        }
        $('#sub-categories').html(options);
    }, 'json');
});

/** Get sub categories */
$(document).on('click', '#home-category', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var id = $(this).attr('data-id');
    $.get(baseUrl + '/get-sub-categories/' + id, function (response) {
        if (response.length > 0) {
            html = '';
            $.each(response, function (index, data) {
                if(data.image != null){
                    var img = `<img src="${ imageBaseUrl + '/' + data.image }" alt="img">`;
                } else{
                    var img = `<img src="${ imageBaseUrl + '/assets/images/cat-icon-1.png' }" alt="img">`;
                }
                html +=
                `<div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <a href="${baseUrl+'/category/'+data.id}" class="catCard">
                        <span class="iconImg">
                            ${ img }
                        </span>
                        <p class="title pt-3">${uppercase(data.title)}</p>
                    </a> 
                </div>`;        
            })
            $('#sub-category-div').html(html);
        } else{
            $('#sub-category-div').html("<p class='title'>Sub category not found.</p>");
        }
    }, 'json');
});

/** Book now */
$("#book-now-form").on('submit', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $('#spb-spiner').removeClass('d-none');
    $('#book-now-btn').prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: baseUrl + '/book-now',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status > 0) {
                location.reload();
            } else {
                $('#spb-spiner').addClass('d-none');
                $('#book-now-btn').prop('disabled', false);
                not(response.message, 'error');
            }
        }
    });
});

/** Book service */
$("#book-service-form").on('submit', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $('#sp-spiner').removeClass('d-none');
    $('#book-service-btn').prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: baseUrl + '/book-service',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status > 0) {
                window.location.href = baseUrl;
            }  else {
                $('#sp-spiner').addClass('d-none');
                $('#book-service-btn').prop('disabled', false);
                not(response.message, 'error');
            }
        }
    });
});


/** Submit vital */
$("#vital-form").on('submit', function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    $('#spv-spiner').removeClass('d-none');
    $('#vital-btn').prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: baseUrl + '/vital',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function (response) {
            if (response.status > 0) {
                location.reload()
            } else {
                $('#spv-spiner').addClass('d-none');
                $('#vital-btn').prop('disabled', false);
                not(response.message, 'error');
            }
        }
    });
});

$('#select-live-location').click( function(){
    var location = $('#location').val();
    if(location == '' || location == undefined){
        not('The location field is required.', 'error');
    } else{
        $('#is_other_address').val('1');
        $('#other_address').val(location);

        var other_city = $('#city').val();
        var other_state = $('#state').val();

        $('#live-address')[0].reset();

        $('#address-card').html(
            `<p class="desc">Address: <span>${ location }</span></p>
            <p class="desc">City: <span>${ other_city }</span></p>
            <p class="desc">State: <span>${ other_state }</span></p>
            `
        );

        $('#mapModal').modal('hide');
    }
})

/** Add new address */
$('#add-new-address-btn').click( function(){
    var other_state = $('#input-other-state').val();
    var other_city = $('#input-other-city').val();
    var other_address = $('#input-other-address').val();
    
    if(other_state == '' || other_state == undefined){
        not('The state field is required.', 'error');
    } else if(other_city == '' || other_city == undefined){
        not('The city field is required.', 'error');
    } else if(other_address == '' || other_address == undefined){
        not('The address field is required.', 'error');
    } else{
        $('#is_other_address').val('1');
        $('#state').val(other_state);
        $('#city').val(other_city);
        $('#address').val(other_address);
        $('#addAdress').modal('hide');
        $('#latitude').val('');
        $('#longitude').val('');

        $('#manually-address')[0].reset();

        $('#address-card').html(
            `<p class="desc">Address: <span>${ other_address }</span></p>
            <p class="desc">City: <span>${ other_city }</span></p>
            <p class="desc">State: <span>${ other_state }</span></p>
            `
        );
    }
});

function uppercase(str){
    return str.toLowerCase().replace(/\b[a-z]/g, function(letter) {
        return letter.toUpperCase();
    });
}