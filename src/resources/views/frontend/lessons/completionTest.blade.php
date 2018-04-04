@extends("lms::layouts.app")

@section("content")
	
	<div class="container">
		<test :test="{{$test}}" url="{{route("tests.grade", $test)}}"
		      success-redirect-url="{{route('lessons.complete', $lesson)}}"
		      fail-redirect-url="{{route('lessons.complete', $lesson)}}"></test>
	</div>
@endsection