<div class="card mb-3">
    <a href="{{route("lessons.show", $lesson->id)}}">
        @include("lms::frontend.lessons.components.lesson_completed_badge")
	    <div class="card-img-top" style="height: 130px; overflow: hidden">
		    <img class="img-fluid"
		         src="{{$lesson->getFirstMediaUrl('coverPic')}}" />
	    </div>
        <div class="card-body"
             style="height: 150px; overflow: hidden">
	        <h3>{{$lesson->title}}</h3>
	        {{--<div class="lesson-summary">{!! $lesson->summary !!}</div>--}}
        </div>
    </a>
</div>