@extends('user.layouts.master')
@section('title', 'Chat')
@section('content')

<section class="gen-section">
	<div class="gen-wrap">
		<div class="topHeading d-flex align-items-center pb-5"> 
			<h1 class="headingMain ms-3">Messages</h1>
		</div>
		<div class="genRow chatrowMain">
			<div class="chatList">
				<div class="chatSearchBar relClass">
					<input type="seach" class="chatSearch" placeholder="Find contacts" id="search-chat-list">
					<img src="{{ asset('assets/images/searchChat.png') }}" alt="img" class="searchIcon2">
				</div>

				<ul class="list-unstyled">
                    <input type="hidden" id="receiverId" value="{{$receiverId}}">
                    @if(count($chatLists) > 0)
                    @foreach($chatLists as $chatList)
					<li class="user-lists" val="{{ $chatList->user_id }}" data-name="{{ $chatList->first_name . ' ' . $chatList->last_name }}">
						<a href="javascript:void(0);" class="chatPerson">	
							<span class="chatPersonImg">
                                @if(!empty($chatList->profile_image))
                                <img src="{{ asset($chatList->profile_image) }}" alt="img">
                                @else
                                <img src="{{ asset('assets/images/user-image.png') }}" alt="img">
                                @endif
							</span>
							<p class="chatName">{{ $chatList->first_name }} {{ $chatList->last_name }}</p>
							@if($chatList->read_count > 0) <p class="msgCounts xy-center read-count">{{ $chatList->read_count }}</p> @endif
						</a>
					</li>
                    @endforeach
                    @endif
				</ul>
			</div>
			<div class="chatContent">
				<div class="contentBody">
					<div class="chatWrap">
						<div class="chatHeader">
							<p class="headName text-center" id="user-fullname">Messages</p>
						</div>
						<div class="chatMid" id="chat-html">
                            <div style="text-align: center; vertical-align: middle; line-height: 450px;">
                                <img src="{{ asset('assets/images/chat.png') }}" alt="">
                                <h4>Select user to start the chat</h4>			
                            </div>				
						</div>
						<div class="typeBox @if($receiverId != null && $receiverId > 0) @else d-none @endif" id="chattingContentBox">
							<textarea class="typeMessage" placeholder="Type your message..." id="chatMessage"></textarea>
							<a href="javascript:void(0);" class="genBtn sendBtn2 xy-center" id="sendMessage">
								Send
							</a>
							<button class="emojiBtn d-none">
								<img src="{{ asset('assets/images/emoji.png') }}" alt="img">
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
    // const socket = io.connect("http://localhost:3038");
    const socket = io.connect("https://server1.appsstaging.com:3038");
    var receiverId = $('#receiverId').val();

	socket.on("connect", () => {
		console.log(socket.connected); // true
	});

    $(document).ready( function(){ 
        if(receiverId > 0){
            get_messages(receiverId);
        }
	});

    $(".user-lists").click( function(){ 
		var id = $(this).attr('val');
        var name = $(this).attr('data-name');
        var dir = $(this);
        $('#user-fullname').text(name)
		$('#receiverId').val(id);

        get_messages(id);

        if(dir.find('.read-count').text().length > 0){
            $.post(baseUrl + '/read-message', {"_token":"{{ csrf_token() }}"}, function (response) {
                dir.find('.read-count').remove();
            }, 'json');
        }
        
        $('#chattingContentBox').removeClass('d-none');
	});

    socket.on("response", (messages) => { 

        var html = '';
        if(messages.object_type == "get_messages"){
			$(messages.data).each(function(i, val){
                if(val.profile_image == null){
                    var image = "{{ asset('assets/images/user-image.png') }}";
                } else{
                    var image = "{{ asset('') }}" + val.profile_image;
                }

                if(val.sender_id == "{{ auth()->id() }}"){
                    html += 
                            `<div class="chatItem rightMsg">
								<div class="textMessage">
									<p class="title">${val.first_name} ${val.last_name}</p>
									<p class="desc">${val.message}</p>
									<p class="timeText">${ time_difference(val.created_at )}</p>
								</div>
								<div class="chatHead ms-2">
									<img src="${image}" alt="img">
								</div>
							</div>`;
                } else{ 
                    html += 
                            `<div class="chatItem leftMsg">
								<div class="chatHead me-2">
									<img src="${image}" alt="img">
								</div>
								<div class="textMessage">
									<p class="title">${val.first_name} ${val.last_name}</p>
									<p class="desc">${val.message}</p>
									<p class="timeText">${ time_difference(val.created_at) }</p>
								</div>
							</div>`;
                }
	        });
            $("#chat-html").html(html);
        } else if(messages.object_type == "get_message"){
            var val = messages.data;

            if(val.profile_image == null){
                var image = "{{ asset('assets/images/user-image.png') }}";
            } else{
                var image = "{{ asset('') }}" + val.profile_image;
            }

            if(val.sender_id == "{{ auth()->id() }}"){
                html += 
                        `<div class="chatItem rightMsg">
                            <div class="textMessage">
                                <p class="title">${val.first_name} ${val.last_name}</p>
                                <p class="desc">${val.message}</p>
                                <p class="timeText">${ time_difference(val.created_at )}</p>
                            </div>
                            <div class="chatHead ms-2">
                                <img src="${image}" alt="img">
                            </div>
                        </div>`;
            } else{ 
                html += 
                        `<div class="chatItem leftMsg">
                            <div class="chatHead me-2">
                                <img src="${image}" alt="img">
                            </div>
                            <div class="textMessage">
                                <p class="title">${val.first_name} ${val.last_name}</p>
                                <p class="desc">${val.message}</p>
                                <p class="timeText">${ time_difference(val.created_at) }</p>
                            </div>
                        </div>`;
            }
            $("#chat-html").append(html);
        }
        $("#chatMessage").val(''); 
        $("#chat-html").animate({ scrollTop: 20000000 }, "slow"); 
	});

    $("#sendMessage").click( function(){ 
        var message = $("#chatMessage").val(); 
		var receiverId = $('#receiverId').val();
		socket.emit("send_message", { sender_id: "{{ auth()->id() }}", receiver_id: receiverId, message:message, type:"text" });
	});

    function get_messages(receiverId){
        socket.emit('get_messages',{
            "sender_id": "{{ auth()->id() }}",
            "receiver_id": receiverId
        });
    }

    function time_difference(datetime){
        const olderDate = new Date(datetime);
        const currentDate = new Date();

        const diff = olderDate - currentDate;
        const formatter = new Intl.RelativeTimeFormat('en', { numeric: 'auto' });
        return formatter.format(Math.round(diff / 86400000), 'day');
    }
</script>

@endpush