<header class="header-bar xy-between">
	<div class="leftCol xy-between">
		<button class="toggleBtn xy-center">
			<i class="fa-solid fa-bars"></i>
		</button>

		<form class="searchBar relClass">
			<input type="search" placeholder="Search..." id="header-search">
			<img src="{{ asset('assets/images/search.png') }}" alt="img" class="searchIcon">
			<div id="suggesstion-box"></div>
		</form>
	</div>
	<div class="rightCol xy-end">
		<a href="#sosModal" data-bs-toggle="modal" class="topBtn xy-center sosBtn">
			<img src="{{ asset('assets/images/sos.png') }}" alt="img">
		</a>
		<a href="#!" class="topBtn xy-center notiBtn" id="notificationDrop">
			<img src="{{ asset('assets/images/bell.png') }}" alt="img" id="test">
			<div id="un_read_notification_count"></div>
		</a>
		<div class="notifiactionWrap" id="notificationWrap">
			<div class="nHeader xy-between pb-3">
				<p class="heading">Notification</p>
				{{--
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" id="ntoggle">
				</div>
				--}}
			</div>
			<div class="innerBody pt-2 pb-2" id="notificationHtml">
				
			</div>
		</div>
		<a href="{{ url('user/my-profile') }}" class="topBtn xy-center profileLink">
			@if(!empty(auth()->user()->profile_image))
			<img src="{{ asset(auth()->user()->profile_image) }}" alt="img" class="userImg">
			@else
			<img src="{{ asset('assets/images/user-image.png') }}" alt="img" class="userImg">
			@endif
		</a>
	</div>
</header>