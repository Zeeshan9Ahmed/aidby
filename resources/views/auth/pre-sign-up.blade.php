@extends('user.layouts.master')
@section('title', 'Pre sign up')
@section('content')

<section class="initial-sec">
	<div class="initial-row">
		<div class="leftCol"></div>
		<div class="rightCol xy-center p-3">
			<form class="loginFrom">
				<h1 class="logHeading">Select Role</h1>
				<p class="logDesc">Select your role to continue</p>

				<div class="btnWrap mt-3">
					<a href="{{ url('auth/sign-up/user') }}" class="logBtn mb-3">
						Sign up as User
					</a>
					<a href="{{ url('auth/sign-up/service') }}" class="logBtn clr1">
						Sign up as Service Provider
					</a>
				</div>
			</form>
			<p class="routeLink">Already have an account? 
                <a href="{{ url('auth/login') }}" class="logBtn clr1 ms-3">Login</a>
            </p>
			<p class="circle"></p>
			<p class="circle2"></p>
		</div>
	</div>
</section>

@endsection