@extends('user.layouts.master')
@section('title', 'Sign up')
@section('content')

<section class="initial-sec">
	<div class="initial-row">
		<div class="leftCol"></div>
		<div class="rightCol xy-center p-3">
			<form class="loginFrom" method="post" action="{{ url('auth/sign-up', $type) }}"> @csrf
				<h1 class="logHeading">Create An Account!</h1>
				<p class="logDesc">Let's Get Started Signup</p>

				<div class="form-group logInput mt-3">
					<input type="text" placeholder="Email Address" class="input1" name="email" value="{{ old('email') }}">
					<img src="{{ asset('assets/images/logIcon-1.png') }}" alt="img" class="logIcon">
				</div>
                {!!$errors->first("email", "<span class='text-danger'>:message</span>")!!}

				<div class="form-group logInput mt-3">
					<input type="password" placeholder="Password" class="input1" name="password">
					<img src="{{ asset('assets/images/logIcon-2.png') }}" alt="img" class="logIcon">
				</div>
                {!!$errors->first("password", "<span class='text-danger'>:message</span>")!!}

				<div class="form-group logInput mt-3">
					<input type="password" placeholder="Confirm Password" class="input1" name="confirm_password">
					<img src="{{ asset('assets/images/logIcon-2.png') }}" alt="img" class="logIcon">
				</div>
                {!!$errors->first("confirm_password", "<span class='text-danger'>:message</span>")!!}

				<div class="btnWrap mt-3">
                    <input type="hidden" value="{{ $type }}" name="type">
                    {!!$errors->first("type", "<span class='text-danger'>:message</span>")!!}
					<button type="submit" class="logBtn">
						Signup
                    </button>
				</div>
			</form>
			<p class="routeLink">Already have an account? 
                <a href="{{ url('auth/login') }}" class="logBtn clr1 ms-3">Login</a>
            </p>
			<p class="circle"></p>
			<p class="circle2"></p>
			<a href="{{ url('auth/pre-sign-up') }}" class="bckBtn">
                <img src="{{ asset('assets/images/back-button.png') }}" alt="img">
			</a>
		</div>
	</div>
</section>

@endsection