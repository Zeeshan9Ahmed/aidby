@extends('user.layouts.master')
@section('title', $content->title)
@section('content')

<section class="gen-section">
	<div class="gen-wrap">
		<div class="TermsWrap">
            {!! $content->content !!}
		</div>
	</div>
</section>

@endsection