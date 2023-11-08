<!DOCTYPE html>
<html>
<head>
	<!-- META TAGS-->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="robots" content="noindex" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
	<!-- META TAGS-->
	<title>@yield('title') - {{ config('app.name') }}</title>

	<link rel="icon" href="{{ asset('assets/images/favicon.png') }}" />

	<!-- BOOTSTRAP 5 -->	
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
	<!-- BOOTSTRAP 5 -->

	<!-- RESPONSIVE NAVIFATION -->
	<link rel="stylesheet" href="{{ asset('assets/css/stellarnav.min.css') }}" />
	<!-- RESPONSIVE NAVIFATION -->

	<!-- SWIPER SLIDER -->
	<link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
	<!-- SWIPER SLIDER -->

	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
	<!-- GOOGLE FONTS -->

	<!-- FANCY BOX IMAGE VIEWER -->
	<link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}" />
	<!-- FANCY BOX IMAGE VIEWER -->

	<!-- FONT AWESOME -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"></li>
	<!-- FONT AWESOME -->

	<!-- STYLE SHEETS -->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
	<!-- STYLE SHEETS -->

	<!-- Notification -->
    <link rel="stylesheet" href="{{ asset('assets/notification/css/jquery.growl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/notification/css/notifIt.css') }}">

	<style>
    
    #search-list {
        float: left;
        list-style: none;
        margin-top: -3px;
        padding: 0;
        position: absolute;
        z-index: 999;
		width: 100%;
    }

    #search-list li {
        padding: 10px;
        background: #f0f0f0;
        border-bottom: #bbb9b9 1px solid;
    }

    #search-list li:hover {
        background: #e2e4eb;
        cursor: pointer;
    }
	.search-ahref{
		color: #41474d !important;
	}
	.TermsWrap {
		background: #ffffff;
		width: 65%;
		margin: 0 auto;
		padding: 30px;
		border-radius: 25px;
		box-shadow: 0px 0px 7px #cdcdcd;
	}
	.headingMain {
		font-size: 36px;
		font-family: 'ProximaNova-Bold';
		color: var(--color-1);
		line-height: 40px;
		padding: 20px 22px;
	}
</style>
</head>

<body>
<div class="fadeWrap"></div>

    