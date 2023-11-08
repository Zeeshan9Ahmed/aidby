<aside class="sideMenu">
	<button class="clsBtn xy-center"><i class="fa-solid fa-xmark"></i></button>
	<ul class="list-unstyled">
		<li>
			<a href="{{ url('user') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-1.png') }}" alt="img">
				</span>
				<span>Home</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/my-booking') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-2.png') }}" alt="img">
				</span>
				<span>My Bookings</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/my-profile') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-3.png') }}" alt="img">
				</span>
				<span>My Profile</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/complete-profile') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-4.png') }}" alt="img">
				</span>
				<span>My Account</span>
			</a>
		</li>
		<li>
			<a href="#bookModal" data-bs-toggle="modal" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-5.png') }}" alt="img">
				</span>
				<span>Book Now</span>
			</a>
		</li>
		<li>
			<a href="javascript:void(0)" class="navItem coming-soon">
				<span>
					<img src="{{ asset('assets/images/nav-icon-6.png') }}" alt="img">
				</span>
				<span>Suggested Price</span>
			</a>
		</li>
		<!-- <li>
			<a href="{{ url('user/vital') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-7.png') }}" alt="img">
				</span>
				<span>Vital</span>
			</a>
		</li> -->
		<li>
			<a href="{{ url('user/chat') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-8.png') }}" alt="img">
				</span>
				<span>Messages</span>
			</a>
		</li>
		<li>
			<a href="{{ url('subscription') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-9.png') }}" alt="img">
				</span>
				<span>Subscription Packages</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/blogs') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-10.png') }}" alt="img">
				</span>
				<span>Blogs</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/blogs/my_blog') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-11.png') }}" alt="img">
				</span>
				<span>My Blogs</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/complete-profile') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-12.png') }}" alt="img">
				</span>
				<span>Settings</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/page/terms-and-condition') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-13.png') }}" alt="img">
				</span>
				<span>Terms & Conditions</span>
			</a>
		</li>
		<li>
			<a href="{{ url('user/page/privacy-policy') }}" class="navItem">
				<span>
					<img src="{{ asset('assets/images/nav-icon-14.png') }}" alt="img">
				</span>
				<span>Privacy Policy</span>
			</a>
		</li>
		<li>
			<a href="{{ url('auth/logout') }}" class="logOut mt-4">
				<span>
					<img src="{{ asset('assets/images/logout-icon.png') }}" alt="img">
				</span>
				<span>Logout</span>
			</a>
		</li>
	</ul>
</aside>
