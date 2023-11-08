// CLANEDER JS
$('#calendar').datepicker({
	inline:true,
	firstDay: 1,
	showOtherMonths:true,
	dayNamesMin:['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
});

// SETTINGS AVATAR START
function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#imagePreview').css('background-image', 'url('+e.target.result +')');
			$('#imagePreview').hide();
			$('#imagePreview').fadeIn(650);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#imageUpload").change(function() {
	readURL(this);
});
// SETTINGS AVATAR END

/// OTP INPUTS START
$('.digit-group').find('input').each(function() {
	$(this).attr('maxlength', 1);
	$(this).on('keyup', function(e) {
		var parent = $($(this).parent());

		if(e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find('input#' + $(this).data('previous'));

			if(prev.length) {
				$(prev).select();
			}
		} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
			var next = parent.find('input#' + $(this).data('next'));

			if(next.length) {
				$(next).select();
			} else {
				if(parent.data('autosubmit')) {
					parent.submit();
				}
			}
		}
	});
});
/// OTP INPUTS END

// SIDE MENU
$('.toggleBtn').click(function(){
	$('.sideMenu').toggleClass('active')
	// $('.fadeWrap2').toggleClass('show')
});
$('.clsBtn').click(function(){
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
		reader.onload = function(e) {
			$('#imagePreview').css('background-image', 'url('+e.target.result +')');
			$('#imagePreview').hide();
			$('#imagePreview').fadeIn(650);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#imageUpload").change(function() {
	readURL(this);
});
/// EDIT-PROFILE-AVATAR JS END (PERSONAL PROFILE)


/// EDIT-PROFILE-AVATAR JS START (VENUE PROFILE) 
function readURL2(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
			$('#imagePreview2').css('background-image', 'url('+e.target.result +')');
			$('#imagePreview2').hide();
			$('#imagePreview2').fadeIn(650);
		}
		reader.readAsDataURL(input.files[0]);
	}
}
$("#imageUpload2").change(function() {
	readURL2(this);
});
/// EDIT-PROFILE-AVATAR JS END (VENUE PROFILE)


$(document).ready(function() {
  // Event handler for clicking on an element
	$('.paymentWrap').click(function() {
    // Remove "active" class from all elements
		$('.paymentWrap').removeClass('active');
		
    // Add "active" class to the clicked element
		$(this).addClass('active');
	});
});


// NOTIFICATION DROPDOWN
$(document).ready(function(){
	$("#notificationDrop").click(function(){
		$(".notifiactionWrap").slideToggle();
		$(".fadeWrap").toggleClass("show");
		$(".notiBtn").toggleClass("show");
	});

	$(".fadeWrap").click(function(){
		$(this).removeClass("show");
		$(".notifiactionWrap").css("display", "none");
		$(".notiBtn").removeClass("show");

	});
});


// SLIDER CARD ACTIVE
$(document).ready(function() {
  // Event handler for clicking on an element
	$('.indexCard ').click(function() {
		$('.indexCard ').removeClass('active');
		$(this).addClass('active');
	});
});




// ====================
// VITAL PAGE SCRIPT
// ====================

// Line Chart 1

var chart    = document.getElementById('chart').getContext('2d'),
    gradient = chart.createLinearGradient(0, 0, 0, 450);

gradient.addColorStop(0, 'rgba(255, 255,255, 0.9)');
gradient.addColorStop(0.7, 'rgba(255, 255, 255, 0.25)');
gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');


var data  = {
    labels: [ '0', '3', '6', '9', '12', '15', '18', '21', '24'],
    datasets: [{
			label: 'Custom Label Name',
			backgroundColor: gradient,
			pointBackgroundColor: 'white',
			borderWidth: 1,
			borderColor: '#fff',
			data: [70, 0, 110, 70, 140, 90, 120, 30, 60,]
    }]
};


var options = {
	responsive: true,
	maintainAspectRatio: true,
	animation: {
		easing: 'easeInOutQuad',
		duration: 520
	},
	scales: {
		xAxes: [{
			gridLines: {
				color: 'rgba(255, 255, 255, 0.9)',
				lineWidth: 0.1
			}
		}],
		yAxes: [{
			gridLines: {
				color: 'rgba(255, 255, 255, 0.9)',
				lineWidth: 0.1
			}
		}]
	},
	elements: {
		line: {
			tension: 0.1
		}
	},
	legend: {
		display: false
	},
	point: {
		backgroundColor: 'white'
	},
	tooltips: {
		titleFontFamily: 'Open Sans',
		backgroundColor: 'rgba(0,0,0,0.3)',
		titleFontColor: 'red',
		caretSize: 5,
		cornerRadius: 2,
		xPadding: 10,
		yPadding: 10
	}
};


var chartInstance = new Chart(chart, {
    type: 'line',
    data: data,
		options: options
});







// Line Chart2



var chart    = document.getElementById('chart2').getContext('2d'),
    gradient = chart.createLinearGradient(0, 0, 0, 450);

gradient.addColorStop(0, 'rgba(255, 255,255, 0.9)');
gradient.addColorStop(0.7, 'rgba(255, 255, 255, 0.25)');
gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');


var data  = {
    labels: [ '0', '3', '6', '9', '12', '15', '18', '21', '24'],
    datasets: [{
			label: 'Custom Label Name',
			backgroundColor: gradient,
			pointBackgroundColor: 'white',
			borderWidth: 1,
			borderColor: '#fff',
			data: [0, 30, 60, 20, 140, 90, 20, 30, 60,]
    }]
};


var options = {
	responsive: true,
	maintainAspectRatio: true,
	animation: {
		easing: 'easeInOutQuad',
		duration: 520
	},
	scales: {
		xAxes: [{
			gridLines: {
				color: 'rgba(255, 255, 255, 0.9)',
				lineWidth: 0.1
			}
		}],
		yAxes: [{
			gridLines: {
				color: 'rgba(255, 255, 255, 0.9)',
				lineWidth: 0.1
			}
		}]
	},
	elements: {
		line: {
			tension: 0.1
		}
	},
	legend: {
		display: false
	},
	point: {
		backgroundColor: 'white'
	},
	tooltips: {
		titleFontFamily: 'Open Sans',
		backgroundColor: 'rgba(0,0,0,0.3)',
		titleFontColor: 'red',
		caretSize: 5,
		cornerRadius: 2,
		xPadding: 10,
		yPadding: 10
	}
};


var chartInstance = new Chart(chart, {
    type: 'line',
    data: data,
		options: options
});





$(function(){
  var $ppc = $('.progress-pie-chart'),
    percent = parseInt($ppc.data('percent')),
    deg = 360*percent/100;
  if (percent > 50) {
    $ppc.addClass('gt-50');
  }
  $('.ppc-progress-fill').css('transform','rotate('+ deg +'deg)');
  $('.ppc-percents span').html(percent+'%');
});









// As of Donut Chart 1

var duration   = 500,
    transition = 200;

drawDonutChart(
  '#donut',
  $('#donut').data('donut'),
  150,
  150,
  ".35em"
);

function drawDonutChart(element, percent, width, height, text_y) {
  width = typeof width !== 'undefined' ? width : 150;
  height = typeof height !== 'undefined' ? height : 150;
  text_y = typeof text_y !== 'undefined' ? text_y : "-.10em";

  var dataset = {
        lower: calcPercent(0),
        upper: calcPercent(percent)
      },
      radius = Math.min(width, height) / 2,
      pie = d3.layout.pie().sort(null),
      format = d3.format(".0%");

  var arc = d3.svg.arc()
        .innerRadius(radius - 20)
        .outerRadius(radius);

  var svg = d3.select(element).append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

  var path = svg.selectAll("path")
        .data(pie(dataset.lower))
        .enter().append("path")
        .attr("class", function(d, i) { return "color" + i })
        .attr("d", arc)
        .each(function(d) { this._current = d; }); // store the initial values

  var text = svg.append("text")
        .attr("text-anchor", "middle")
        .attr("dy", text_y);

  if (typeof(percent) === "string") {
    text.text(percent);
  }
  else {
    var progress = 0;
    var timeout = setTimeout(function () {
      clearTimeout(timeout);
      path = path.data(pie(dataset.upper)); // update the data
      path.transition().duration(duration).attrTween("d", function (a) {
        // Store the displayed angles in _current.
        // Then, interpolate from _current to the new angles.
        // During the transition, _current is updated in-place by d3.interpolate.
        var i  = d3.interpolate(this._current, a);
        var i2 = d3.interpolate(progress, percent)
        this._current = i(0);
        return function(t) {
          text.text( format(i2(t) / 100) );
          return arc(i(t));
        };
      }); // redraw the arcs
    }, 200);
  }
};

function calcPercent(percent) {
  return [percent, 100-percent];
};


// As of Donut Chart 2

var duration   = 500,
    transition = 200;

drawDonutChart(
  '#donut2',
  $('#donut2').data('donut'),
  150,
  150,
  ".35em"
);

function drawDonutChart(element, percent, width, height, text_y) {
  width = typeof width !== 'undefined' ? width : 150;
  height = typeof height !== 'undefined' ? height : 150;
  text_y = typeof text_y !== 'undefined' ? text_y : "-.10em";

  var dataset = {
        lower: calcPercent(0),
        upper: calcPercent(percent)
      },
      radius = Math.min(width, height) / 2,
      pie = d3.layout.pie().sort(null),
      format = d3.format(".0%");

  var arc = d3.svg.arc()
        .innerRadius(radius - 20)
        .outerRadius(radius);

  var svg = d3.select(element).append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

  var path = svg.selectAll("path")
        .data(pie(dataset.lower))
        .enter().append("path")
        .attr("class", function(d, i) { return "color" + i })
        .attr("d", arc)
        .each(function(d) { this._current = d; }); // store the initial values

  var text = svg.append("text")
        .attr("text-anchor", "middle")
        .attr("dy", text_y);

  if (typeof(percent) === "string") {
    text.text(percent);
  }
  else {
    var progress = 0;
    var timeout = setTimeout(function () {
      clearTimeout(timeout);
      path = path.data(pie(dataset.upper)); // update the data
      path.transition().duration(duration).attrTween("d", function (a) {
        // Store the displayed angles in _current.
        // Then, interpolate from _current to the new angles.
        // During the transition, _current is updated in-place by d3.interpolate.
        var i  = d3.interpolate(this._current, a);
        var i2 = d3.interpolate(progress, percent)
        this._current = i(0);
        return function(t) {
          text.text( format(i2(t) / 100) );
          return arc(i(t));
        };
      }); // redraw the arcs
    }, 200);
  }
};

function calcPercent(percent) {
  return [percent, 100-percent];
};

// As of Donut Chart 3

var duration   = 500,
    transition = 200;

drawDonutChart(
  '#donut3',
  $('#donut3').data('donut'),
  150,
  150,
  ".35em"
);

function drawDonutChart(element, percent, width, height, text_y) {
  width = typeof width !== 'undefined' ? width : 150;
  height = typeof height !== 'undefined' ? height : 150;
  text_y = typeof text_y !== 'undefined' ? text_y : "-.10em";

  var dataset = {
        lower: calcPercent(0),
        upper: calcPercent(percent)
      },
      radius = Math.min(width, height) / 2,
      pie = d3.layout.pie().sort(null),
      format = d3.format(".0%");

  var arc = d3.svg.arc()
        .innerRadius(radius - 20)
        .outerRadius(radius);

  var svg = d3.select(element).append("svg")
        .attr("width", width)
        .attr("height", height)
        .append("g")
        .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

  var path = svg.selectAll("path")
        .data(pie(dataset.lower))
        .enter().append("path")
        .attr("class", function(d, i) { return "color" + i })
        .attr("d", arc)
        .each(function(d) { this._current = d; }); // store the initial values

  var text = svg.append("text")
        .attr("text-anchor", "middle")
        .attr("dy", text_y);

  if (typeof(percent) === "string") {
    text.text(percent);
  }
  else {
    var progress = 0;
    var timeout = setTimeout(function () {
      clearTimeout(timeout);
      path = path.data(pie(dataset.upper)); // update the data
      path.transition().duration(duration).attrTween("d", function (a) {
        // Store the displayed angles in _current.
        // Then, interpolate from _current to the new angles.
        // During the transition, _current is updated in-place by d3.interpolate.
        var i  = d3.interpolate(this._current, a);
        var i2 = d3.interpolate(progress, percent)
        this._current = i(0);
        return function(t) {
          text.text( format(i2(t) / 100) );
          return arc(i(t));
        };
      }); // redraw the arcs
    }, 200);
  }
};

function calcPercent(percent) {
  return [percent, 100-percent];
};





