@include('user.layouts.header')

@if(Auth::check())

    @if(Auth::user()->type == 'user' && auth()->user()->expires_at >= \Carbon\Carbon::today())
        @include('user.layouts.user.header-bar')
        @include('user.layouts.user.side-bar')
    @elseif(Auth::user()->type == 'service' && auth()->user()->expires_at >= \Carbon\Carbon::today())
        @include('service.layouts.service.header-bar')
        @include('service.layouts.service.side-bar')
    @endif
@endif

@yield('content')

@if(Session::has('success')) <input type="hidden" id="mSg" color="success" value="{{ Session::get('success') }}"> @endif
@if(Session::has('error'))   <input type="hidden" id="mSg" color="error" value="{{ Session::get('error') }}">     @endif
<input type="hidden" id="baseUrl" value="{{ url('/') }}" />

@include('user.layouts.footer')