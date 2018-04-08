@extends("lms::layouts.app")

@section("content")
	<div class="container">
		{!! \DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs::render("question", $test) !!}
		<div class="row justify-content-center">
	        <div class="col-12 mb-3">
		        @include("lms::admin.components.alert")
		        <div class="card">
	                <div class="card-header bg-primary text-white">
		                Questions for Test: {{$test->title}}
		                <button type="button" data-toggle="modal"
		                        data-target="#question_type"
		                        class="btn btn-success btn-sm float-right">Create New Question</button>
		                <a href="{{route('tests.questions.browse', $test)}}"
		                   class="btn btn-success btn-sm float-right mr-3">Add from Existing Questions</a>
	                </div>
			        <div class="card-body">
				        <order-list inline-template>
							<div class=>
								<ul class="list-unstyled list-inline col-sm-12">
									<li class="row">
										<div class="col-sm-1"><strong>Order</strong></div>
										<div class="col-sm-7"><strong>Content</strong></div>
										<div class="col-sm-2"><strong>Is Active</strong></div>
										<div class="col-sm-2"><strong>Actions</strong></div>
									</li>
								</ul>
								<ol class="list-unstyled list-inline col-sm-12 units"
								    ref="sotableList">
									 @foreach($test->questions as $index=>$question)
										<li class="row mb-2 p-2 border border-light rounded"
										    data-id="{{$question->id}}">
										<div class="col-sm-1">{{$index+1}}</div>
					                    <div class="col-sm-7">
					                        <div class="question-content">{!! $question->content !!}</div>
					                    </div>
					                    <div class="col-sm-2">
						                    <h5>
						                        @if($question->is_active)
								                    <span class="badge badge-success">Yes</span>
							                    @else
								                    <span class="badge badge-warning">No</span>
							                    @endif
						                    </h5>
					                    </div>
					                    <div class="col-sm-2">
						                    <div class="btn-group btn-group-sm"
						                         role="group"
						                         aria-label="Basic example">
											  <a href="{{route("tests.questions.edit",[$test, $question])}}"
											     class="btn btn-info">Edit</a>
											  <button type="button"
											          class="btn btn-danger"
											          @click.prevent="deleteItem('{{route('tests.questions.destroy', [$test, $question])}}', removeDom)"
											  >Delete</button>
											</div>
					                    </div>
				                    </li>
									@endforeach
									
								</ol>
								<div class="col-12">
									<button class="btn btn-info btn-block"
									        @click.prevent="updateOrder('here')">Update Order</button>
								</div>
							</div>
						</order-list>
			        </div>
	            </div>
	        </div>
	    </div>
		@include("lms::admin.tests.questions.components.question_type_modal",['modalId'=>'question_type'])
	</div>
@endsection