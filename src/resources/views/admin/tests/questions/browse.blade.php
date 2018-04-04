@extends("lms::layouts.app")

@section("content")
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <form action="{{route("tests.questions.browse", $test)}}"
	              method="POST">
		        {{csrf_field()}}
		
		        <div class="card">
                <div class="card-header bg-primary text-white">
	                All Questions <button
			                class="btn btn-sm btn-success float-right">Update</button>
                </div>

			        <table class="table">
                    <thead>
                        <th>Select</th>
                        <th>Content</th>
                        <th>Is Active</th>
                    </thead>
	                <tbody>
	                    @foreach($questions as $question)
		                    <tr>
			                    <td><input type="checkbox"
			                               name="question_ids[]"
			                               value="{{$question->id}}"
			                               @if(in_array($question->id, $test->questions->pluck('id')->toArray()))
			                               checked
						                    @endif
				                    ></td>
			                    <td>
			                        <div class="question-content">{!! $question->content !!}</div>
			                    </td>
			                    <td>
				                    <h5>
				                        @if($question->is_active)
						                    <span class="badge badge-success">Yes</span>
					                    @else
						                    <span class="badge badge-warning">No</span>
					                    @endif
				                    </h5>
			                    </td>
		                    </tr>
	                    @endforeach
	                </tbody>
                </table>
            
            </div>
	        </form>
        </div>
    </div>
	</div>
@endsection