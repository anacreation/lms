@extends("lms::layouts.app")

@section("content")
	
	<div class="container justify-content-center">
		@include("lms::admin.components.alert")
		<img class="card-img-top mb-3"
		     src="{{$lesson->getFirstMediaUrl('coverPic')}}" />
		<h1>{{$lesson->getName()}}</h1>
		<ul class="list-unstyled">
			<li>Requirement: {{$lesson->prerequisites->count()?$lesson->showRequiredLessons():"None"}}</li>
		</ul>
		<div>{!! $lesson->summary !!}</div>
		<div class="btn-group d-flex">
				<a class="btn btn-success w-100 @if(!Auth::user()->hasFulfillRequirementsFor($lesson))disabled @endif"
				   href="{{!Auth::user()->hasFulfillRequirementsFor($lesson)?"":route("lessons.start", $lesson)}}"
				>Start</a>
		</div>
	</div>
@endsection