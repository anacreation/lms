@if(Auth::user()->hasCompletedLesson($lesson))
	<span class="badge badge-success mr-3 mt-3"
	      style="position:absolute; right:0">Completed</span>
@endif