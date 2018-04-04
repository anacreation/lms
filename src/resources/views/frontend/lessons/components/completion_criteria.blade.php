@if($lesson->isCompletedBy("click"))
	@if($lesson->isCompletedByUser(Auth::user()))
		<h4>You have passed the test.</h4>
	@else
		<a class="btn btn-success"
		   href="{{route("lessons.complete", $lesson)}}">Completed</a>
	@endif
	
@elseif($lesson->isCompletedBy("test"))
	@if($lesson->isCompletedByUser(Auth::user()))
		<h4>You have passed the test.</h4>
	@else
		<a href="{{route('lessons.completion.test', $lesson)}}"><h4>Go To Test</h4></a>
	@endif
@elseif($lesson->isCompletedBy("time"))
	@if($lesson->isCompletedByUser(Auth::user()))
		<h4>You have passed the test.</h4>
	@else
		<timer :seconds="{{$lesson->completionCriteria->seconds}}"
		       completed-url="{{route("lessons.complete", $lesson)}}"></timer>
	@endif
	
@endif