@extends("lms::layouts.app")

@section("content")
	
	<div class="container">
		<test :test="{{$test}}"
		      success-redirect-url="{{route("lessons.users.attempts", [$lesson, $user])}}"
		      :attempt="{{$attempt}}"></test>
	</div>
@endsection