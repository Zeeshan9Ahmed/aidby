@extends('user.layouts.master')
@section('title', 'Login')
@section('content')

<section class="initial-sec">
	<div class="initial-row">
		<div class="leftCol"></div>
		<div class="rightCol xy-center p-3">
			<form class="loginFrom" method="post" action="{{ url('auth/login') }}"> @csrf
				<h1 class="logHeading">Welcome Back!</h1>
				<p class="logDesc">Login To Your Account</p>

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

				<div class="form-group logInput mt-3 xy-between">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="flexCheckChecked" name="remember" value="1">
						<label class="form-check-label" for="flexCheckChecked">
							Remember me
						</label>
					</div>
					<a href="forgot-password.php" class="frgtPass">Forgot Password?</a>
				</div>
				<div class="btnWrap mt-3">
					<button type="submit" class="logBtn">
						Login
					</button>
				</div>
				<p class="sepraterLine">Or Login With</p>
				<div class="btnWrap">
					{{-- <a href="#!" class="logBtn clr1 gooleBtn social-login" socialTitle="google" id=""> --}}
					<a href="#userTypeModal" data-bs-toggle="modal" class="logBtn clr1 gooleBtn">
						<i class="fa-brands fa-google me-2"></i>Login With Google
					</a>
				</div>
			</form>

			<form id="social-login-form" action="" method="POST" style="display: none;">
				@csrf
				<input id="social-login-type" name="social_type" type="text">
				<input id="social-login-token" name="social_token" type="text">
				<input id="social-login-email" name="email" type="text">
				<input id="social-login-fullname" name="full_name" type="text">
				<input id="social-login-user-type" name="user_type" type="text">
			</form>

			<p class="routeLink">Don't have an account? 
				<a href="{{ url('auth/pre-sign-up') }}" class="logBtn clr1 ms-3">Signup</a>
			</p>
			<p class="circle"></p>
			<p class="circle2"></p>
			<a href="pre-login.php" class="bckBtn d-none">
				<img src="{{ asset('assets/images/back-button.png') }}" alt="img">
			</a>
		</div>
	</div>
</section>

<!-- Emegrncy Contacts Modal Start-->
<div class="modal fade genModal" id="userTypeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form class="genForm row">
                    <div class="col-12">
						<div class="btnWrap mt-3">
							<a href="{{ url('auth/sign-up/user') }}" class="logBtn mb-3 social-login" socialTitle="google" userType="user">
								Login as User
							</a>
							<a href="{{ url('auth/sign-up/service') }}" class="logBtn clr1 social-login" socialTitle="google" userType="service">
								Login as Service Provider
							</a>
						</div>
                    </div>
                </form>
                <button class="closeModal" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        </div>
    </div>
</div>
<!-- Emegrncy Contacts Modal End-->

@endsection