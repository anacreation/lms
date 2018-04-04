@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">New Question</div>
		        
		        <div class="card-body">
			        @if(Request::get('question_type') === 'multiple_choice')
				        @include('lms::admin.tests.questions.components.mc_question.create')
			        @else
				        @include('lms::admin.tests.questions.components.fill_in_the_blank_question.create')
			        @endif
		        </div>
            </div>
        </div>
    </div>
	</div>
@endsection