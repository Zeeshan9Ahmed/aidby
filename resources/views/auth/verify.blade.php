@extends('user.layouts.master')
@section('title', 'Verify')
@section('content')

<section class="initial-sec">
	<div class="initial-row">
		<div class="leftCol"></div>
		<div class="rightCol xy-center p-3">
			<form class="loginFrom" method="post" action="{{ url('auth/verify') }}"> @csrf
				<h1 class="logHeading">OTP Verification</h1>
				<p class="logDesc pb-3">Enter Verification Code To Verify</p>
				<div method="get" class="digit-group loginForm mb-3" data-group-name="digits" data-autosubmit="false" autocomplete="off">
					<input type="text" id="digit-1" name="digit_1" data-next="digit-2" maxlength="1" placeholder="-" required>
					<input type="text" id="digit-2" name="digit_2" data-next="digit-3" data-previous="digit-1" maxlength="1" placeholder="-" required>
					<input type="text" id="digit-3" name="digit_3" data-next="digit-4" data-previous="digit-2" maxlength="1" placeholder="-" required>
					<input type="text" id="digit-4" name="digit_4" data-next="digit-5" data-previous="digit-3" maxlength="1" placeholder="-" required>
					<input type="text" id="digit-5" name="digit_5" data-next="digit-6" data-previous="digit-4" maxlength="1" placeholder="-" required>
					<input type="text" id="digit-6" name="digit_6" data-next="digit-7" data-previous="digit-5" maxlength="1" placeholder="-" required>
				</div>
				<div class="btnWrap mt-3">
					<button type="submit" class="logBtn mb-3">
						Continue
					</button>
				</div>
			</form>
			<p class="circle"></p>
			<p class="circle2"></p>
			<a href="forgot-password.php" class="bckBtn d-none">
				<img src="{{ asset('assets/images/back-button.png') }}" alt="img">
			</a>
		</div>
	</div>
</section>

@endsection