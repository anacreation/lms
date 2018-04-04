@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">Edit Question</div>
		        
		        <div class="card-body">
			       @if($question->QuestionType->code === "MultipleMultipleChoice")
				        @include('lms::admin.tests.questions.components.mc_question.edit')
			        @else
				        @include('lms::admin.tests.questions.components.fill_in_the_blank_question.edit')
			        @endif
		        </div>
            </div>
        </div>
    </div>
	</div>
@endsection