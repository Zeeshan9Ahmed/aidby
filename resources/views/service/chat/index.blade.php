@extends('service.layouts.master')
@section('title', 'Home')
@section('content')
<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading d-flex align-items-center pb-5">

			<h1 class="headingMain ms-3">Messages</h1>
		</div>
		<div class="genRow chatrowMain">
			<div class="chatList">
				<div class="chatSearchBar relClass">
					<input type="seach" class="chatSearch" id="search" placeholder="Find contacts">
					<img src="{{asset('service_provider_assets/images/searchChat.png')}}" alt="img" class="searchIcon2">
				</div>

				<ul class="list-unstyled" id="inbox_html">

					{{--
						<li>
						<a href="#!" class="chatPerson">	
							<span class="chatPersonImg">
								<img src="{{asset('service_provider_assets/images/mem2.png')}}" alt="img">
					<p class="onlineDot type2"></p>
					</span>
					<p class="chatName">Malcolm Quaday</p>
					<p class="msgCounts xy-center">5</p>
					</a>
					</li>
					<li>
						<a href="#!" class="chatPerson">
							<span class="chatPersonImg">
								<img src="{{asset('service_provider_assets/images/mem3.png')}}" alt="img">
								<p class="onlineDot type2"></p>
							</span>
							<p class="chatName">Lindsey Rivard</p>
						</a>
					</li>
					<li>
						<a href="#!" class="chatPerson">
							<span class="chatPersonImg">
								<img src="{{asset('service_provider_assets/images/mem4.png')}}" alt="img">
								<p class="onlineDot"></p>
							</span>
							<p class="chatName">Elizabeth Hurton</p>
							<p class="msgCounts xy-center">1</p>
						</a>
					</li>
					<li>
						<a href="#!" class="chatPerson">
							<span class="chatPersonImg">
								<img src="{{asset('service_provider_assets/images/mem5.png')}}" alt="img">
								<p class="onlineDot"></p>
							</span>
							<p class="chatName">Albert Pollock</p>
						</a>
					</li>
					<li>
						<a href="#!" class="chatPerson">
							<span class="chatPersonImg">
								<img src="{{asset('service_provider_assets/images/mem6.png')}}" alt="img">
								<p class="onlineDot"></p>
							</span>
							<p class="chatName">Francesca Metts</p>
							<p class="msgCounts xy-center">2</p>
						</a>
					</li>
					<li>
						<a href="#!" class="chatPerson">
							<span class="chatPersonImg">
								<img src="{{asset('service_provider_assets/images/mem5.png')}}" alt="img">
								<p class="onlineDot"></p>
							</span>
							<p class="chatName">Francesca Metts</p>
							<p class="msgCounts xy-center">2</p>
						</a>
					</li>
					--}}
				</ul>
			</div>



			<div class="chatContent">
				<div class="contentBody">
					<div class="chatWrap">
						<div class="chatHeader">
							<p class="headName text-center" id="user_name">Messages</p>
						</div>
						<div class="chatMid" id="chat">

							<div style="text-align: center; vertical-align: middle; line-height: 450px;">
								<img src="{{ asset('assets/images/chat.png') }}" alt="">
								<h4>Select user to start the chat</h4>
							</div>


						</div>


						<div id="text-input" class="typeBox d-none">
							<textarea class="typeMessage" id="chat_message" placeholder="Type your message..."></textarea>
							<input type="hidden" id="receiver_id" value="" />
							<a href="#!" class="genBtn sendBtn2 xy-center" id="send_message">
								Send
							</a>
							<button class="emojiBtn">
								<img src="{{asset('service_provider_assets/images/emoji.png')}}" alt="img">
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


@endsection
@push('scripts')
<script src="https://cdn.socket.io/4.4.1/socket.io.min.js" integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous"></script>

<script>
	$(document).ready(function() {
		var users = {!!json_encode($chatLists) !!};
		inbox = generateChatInbox(users);
		$('#inbox_html').html(inbox);

		function generateChatInbox(inboxes) {
			if (inboxes.length === 0) return `<p class="noChat xy-center">User Not Found</p>`;

			return inboxes.map((inbox) => {
				imageSrc = "";
				imageSrc = inbox.profile_image ? "{{ asset('') }}" + inbox.profile_image : "{{asset('service_provider_assets/images/mem1.png')}}";

				const msgCounts = inbox.read_count > 0 ? `<p class="msgCounts xy-center">${inbox.read_count}</p>` : "";

				return `<li id="users" data-id="${inbox.user_id}" data-user_name="${inbox.first_name} ${inbox.last_name}">
				<a href="#!" class="chatPerson">	
					<span class="chatPersonImg">
					<img src="${imageSrc}" alt="img">
					</span>
					<p class="chatName">${inbox.first_name} ${inbox.last_name}</p>
					${msgCounts}
				</a>
				</li>`.trim(); // Use trim() to remove leading/trailing whitespace
			}).join("");
		}

		const filterItems = (needle, haystack) => {
			let query = needle.toLowerCase();
			return haystack.filter(item =>
				(item.first_name?.toLowerCase().indexOf(query) >= 0) ||
				(item.last_name?.toLowerCase().indexOf(query) >= 0)
			);
		}

		$('#search').keyup(function(e) {
			search = $('#search').val()

			inboxes = filterItems(search, users);

			$("#inbox_html").html(generateChatInbox(inboxes));

			if (e.keyCode == 8) {
				// $('#inbox_html').html(generateChatInbox(filterItems(search, users)))
			}
		})

		const socket = io.connect("https://server1.appsstaging.com:3038");
		// const socket = io.connect("http://localhost:3038");

		socket.on("connect", () => {
			console.log(socket.connected); // true
		});

		socket.on("error", (error_messages) => {
			not('Something went wrong', 'error');
		});



		socket.on("disconnect", () => {
			console.log(socket.connected); // false
		});

		user_id = "{{auth()->id()}}"
		base_path = $('#baseUrl').val() + "/";
		local_image = `${base_path}service_provider_assets/images/mem1.png`;

		function generateChatMessages(messages) {
			return messages.map((message) => {

				console.log(' message/// ', message);

				const image_url = message.profile_image ? base_path + message.profile_image : local_image;
				const chatItemClass = message.sender_id == user_id ? "rightMsg" : "leftMsg";

				let chatItem = `<div class="chatItem ${chatItemClass}">`;

				if (chatItemClass === "leftMsg") {
					chatItem += `<div class="chatHead me-2">`;
					chatItem += `<img src="${image_url}" alt="img">`;
					chatItem += `</div>`;
				}

				chatItem += `<div class="textMessage">`;
				chatItem += `<p class="title">${message.first_name} ${message.last_name}</p>`;
				chatItem += `<p class="desc">${message.message}</p>`;
				chatItem += `<p class="timeText">${ time_difference( message.created_at ) }</p>`;
				chatItem += `</div>`;

				if (chatItemClass === "rightMsg") {
					chatItem += `<div class="chatHead me-2">`;
					chatItem += `<img src="${image_url}" alt="img">`;
					chatItem += `</div>`;
				}

				chatItem += `</div>`;

				return chatItem;
			});
		}


		$(document).on('click', '#users', function() {
			user_data = $(this)
			// dir = $(this);
			
			if(user_data.find('.msgCounts').text().length > 0){
				$.post(baseUrl + '/read-message', {"_token":"{{ csrf_token() }}"}, function (response) {
					user_data.find('.msgCounts').remove();
				}, 'json');
        	}
			
			sender_id = user_id;
			receiver_id = user_data.attr('data-id');
			user_name = user_data.attr('data-user_name');
			$("#text-input").removeClass("d-none")
			$("#receiver_id").val(receiver_id);
			$("#user_name").text(user_name);

			socket.emit('get_messages', {
				"sender_id": sender_id,
				"receiver_id": receiver_id,
			});

		})

		$(document).on('click', '#send_message', function() {
			message = $("#chat_message").val();

			receiver_id = $("#receiver_id").val();
			sender_id = user_id;
			if (!message) {
				not('Message field can not be empty', 'error');
				return;
			}
			socket.emit("send_message", {
				"sender_id": sender_id,
				"receiver_id": receiver_id,
				"message": message,
				"type": "text"
			});
		})
		socket.on("response", (messages) => {
			// append single msg for chat
			if (messages.object_type == "get_message") {
				$("#chat").append(generateChatMessages([messages.data]));
				$("#chat_message").val('');
			} else if (messages.object_type == "get_messages") {
				// all chat append
				// console.log(messages.data)
				$("#chat").html(generateChatMessages(messages.data));
				$("#chat").animate({ scrollTop: 20000000 }, "slow"); 

			}

		});


		function time_difference(datetime){
			const olderDate = new Date(datetime);
			const currentDate = new Date();

			const diff = olderDate - currentDate;
			const formatter = new Intl.RelativeTimeFormat('en', { numeric: 'auto' });
			return formatter.format(Math.round(diff / 86400000), 'day');
    	}




	});
</script>
@endpush