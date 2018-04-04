@extends('lms::layouts.app')

@section('content')
	<div class="container">
		@include("lms::admin.components.alert")
		
		<div class="row justify-content-center">
	
	    <div class="col-lg-6 col-md-5 mb-3">
            <div class="card">
                <div class="card-header bg-info text-white">Featured Courses</div>

                <div class="card-body">
	                @foreach($lessons as $lesson)
		                @if(!Auth::user()->hasCompletedLesson($lesson))
			                @include("lms::frontend.lessons.components.lesson_card", compact("lesson"))
		                @endif
	                @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-5 mb-3">
            <div class="row">
	            <div class="col-12">
		            <div class="card">
	                    <div class="card-header">Assigned Lessons</div>
	                    <div class="card-body">
		                    @foreach(Auth::user()->getAssignedCurricula() as $curriculum)
			                    @foreach($curriculum->items as $learningItem)
				                    @if($learningItem->learning->is_active)
					                    @include("lms::frontend.lessons.components.lesson_card", ["lesson"=>$learningItem->learning])
				                    @endif
			                    @endforeach
		                    @endforeach
	                    </div>
	                </div>
	            </div>
            </div>
        </div>
        <div class="col-md-2 mb-3">
            <div class="card">
                <div class="card-header">Another</div>

                <div class="card-body">
	                You are logged in!
                </div>
            </div>
        </div>
    </div>
	</div>
@endsection

