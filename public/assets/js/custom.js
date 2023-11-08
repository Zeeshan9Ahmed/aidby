
// CLANEDER JS
$('#calendar').datepicker({
	inline: true,
	firstDay: 1,
	showOtherMonths: true,
	dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
});

// SETTINGS AVATAR START
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
			$('#imagePreview').hide();
			$('#imagePreview').fadeIn(650);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#imageUpload").change(function () {
	readURL(this);
});
// SETTINGS AVATAR END

/// OTP INPUTS START
$('.digit-group').find('input').each(function () {
	$(this).attr('maxlength', 1);
	$(this).on('keyup', function (e) {
		var parent = $($(this).parent());

		if (e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find('input#' + $(this).data('previous'));

			if (prev.length) {
				$(prev).select();
			}
		} else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
			var next = parent.find('input#' + $(this).data('next'));

			if (next.length) {
				$(next).select();
			} else {
				if (parent.data('autosubmit')) {
					parent.submit();
				}
			}
		}
	});
});
/// OTP INPUTS END

// SIDE MENU
$('.toggleBtn').click(function () {
	$('.sideMenu').toggleClass('active')
	// $('.fadeWrap2').toggleClass('show')
});
$('.clsBtn').click(function () {
	$('.sideMenu').removeClass('active')
});

// DATE SLIDER
var swiper = new Swiper(".dateSlide", {
	slidesPerView: 6,
	spaceBetween: 40,
	loop: true,
	breakpoints: {
		310: {
			slidesPerView: 2,
		},
		575: {
			slidesPerView: 4,
		},
		767: {
			slidesPerView: 4,
		},
		991: {
			slidesPerView: 4,
		},
		1440: {
			slidesPerView: 6,
		},
	},
});

// INDEX SLIDER
var swiper = new Swiper(".indexSlide", {
	slidesPerView: 6,
	loop: true,
	spaceBetween: 24,
	breakpoints: {
		310: {
			slidesPerView: 2,
		},
		575: {
			slidesPerView: 3,
		},
		767: {
			slidesPerView: 6,
		},
		1280: {
			slidesPerView: 4,
		},
		1300: {
			slidesPerView: 6,
		},
	},
});

// MULTIPLE IMAGE UPLOADER (ADD NEW)
$("#fileUpload").on('change', function () {

	//Get count of selected files
	var countFiles = $(this)[0].files.length;

	var imgPath = $(this)[0].value;
	var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
	var image_holder = $("#image-holder");
	image_holder.empty();

	if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
		if (typeof (FileReader) != "undefined") {

			//loop for each file selected for uploaded.
			for (var i = 0; i < countFiles; i++) {

				var reader = new FileReader();
				reader.onload = function (e) {
					$("<img />", {
						"src": e.target.result,
						"class": "thumb-image"
					}).appendTo(image_holder);
				}

				image_holder.show();
				reader.readAsDataURL($(this)[0].files[i]);
			}

		} else {
			alert("This browser does not support FileReader.");
		}
	} else {
		alert("Pls select only images");
	}
});

/// EDIT-PROFILE-AVATAR JS START (PERSONAL PROFILE) 
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
			$('#imagePreview').hide();
			$('#imagePreview').fadeIn(650);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#imageUpload").change(function () {
	readURL(this);
});
/// EDIT-PROFILE-AVATAR JS END (PERSONAL PROFILE)


/// EDIT-PROFILE-AVATAR JS START (VENUE PROFILE) 
function readURL2(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#imagePreview2').css('background-image', 'url(' + e.target.result + ')');
			$('#imagePreview2').hide();
			$('#imagePreview2').fadeIn(650);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#imageUpload2").change(function () {
	readURL2(this);
});
/// EDIT-PROFILE-AVATAR JS END (VENUE PROFILE)


$(document).ready(function () {
	// Event handler for clicking on an element
	// $('.paymentWrap').click(function() {
	$(document).on('click', '.paymentWrap', function () {
		// Remove "active" class from all elements
		$('.paymentWrap').removeClass('active');

		// Add "active" class to the clicked element
		$(this).addClass('active');
	});
});


// NOTIFICATION DROPDOWN
$(document).ready(function () {
	$("#notificationDrop").click(function () {
		$(".notifiactionWrap").slideToggle();
		$(".fadeWrap").toggleClass("show");
		$(".notiBtn").toggleClass("show");
	});

	$(".fadeWrap").click(function () {
		$(this).removeClass("show");
		$(".notifiactionWrap").css("display", "none");
		$(".notiBtn").removeClass("show");

	});
});


// SLIDER CARD ACTIVE
$(document).ready(function () {
	// Event handler for clicking on an element
	$('.indexCard ').click(function () {
		$('.indexCard ').removeClass('active');
		$(this).addClass('active');
	});
});






// star //
$(document).ready(function(){
  
	/* 1. Visualizing things on Hover - See next part for action on click */
	$('#stars li').on('mouseover', function(){
	  var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
	 
	  // Now highlight all the stars that's not after the current hovered star
	  $(this).parent().children('li.star').each(function(e){
		if (e < onStar) {
		  $(this).addClass('hover');
		}
		else {
		  $(this).removeClass('hover');
		}
	  });
	  
	}).on('mouseout', function(){
	  $(this).parent().children('li.star').each(function(e){
		$(this).removeClass('hover');
	  });
	});
	
	
	/* 2. Action to perform on click */
	$('#stars li').on('click', function(){
	  var onStar = parseInt($(this).data('value'), 10); // The star currently selected
	  $('#rating-g').val(onStar);
	  var stars = $(this).parent().children('li.star');
	  
	  for (i = 0; i < stars.length; i++) {
		$(stars[i]).removeClass('selected');
	  }
	  
	  for (i = 0; i < onStar; i++) {
		$(stars[i]).addClass('selected');
	  }
	  
	  // JUST RESPONSE (Not needed)
	  var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
	  var msg = "";
	  if (ratingValue > 1) {
		  msg = "Thanks! You rated this " + ratingValue + " stars.";
	  }
	  else {
		  msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
	  }
	  responseMessage(msg);
	  
	});
	
	
  });
  
  
  function responseMessage(msg) {
	$('.success-box').fadeIn(200);  
	$('.success-box div.text-message').html("<span>" + msg + "</span>");
  }











