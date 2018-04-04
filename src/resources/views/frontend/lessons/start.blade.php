@extends("lms::layouts.app")

@section("content")
	<div class="container justify-content-center">
		{!! \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render("start", $lesson) !!}
		<h1>Start Lesson: {{$lesson->getName()}}</h1>
		
		@foreach($lesson->contents as $content)
			<div>{!! $content->content->content !!}</div>
		@endforeach
		
		@if($lesson->hasChildren())
			@foreach($lesson->getOrderedChildren() as $unit)
				<div class="card bg-primary mb-2">
				<div class="card-body py-2">
						<a href="{{route('lessons.start',$unit)}}"
						   class="text-light">{{$unit->getName()}}
							@if($unit->isCompletedByUser(Auth::user()))
								<span class="badge badge-success pull-right">Completed</span>
							@endif
						</a>
				</div>
			</div>
			@endforeach
		@endif
		
		@if($lesson->allChildrenCompleted(Auth::user()))
			@include("lms::frontend.lessons.components.completion_criteria")
		@else
			@include("lms::frontend.lessons.components.completedNotice")
		@endif
	</div>
@endsection