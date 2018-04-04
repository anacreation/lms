@extends("lms::layouts.app")

@section("content")
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">
	                Tests
	                <a href="{{route('tests.create')}}"
	                   class="btn btn-success btn-sm float-right">Create</a>
                </div>

                <table class="table">
                    <thead>
                        <th>Title</th>
                        <th>Is Active</th>
                        <th>Actions</th>
                    </thead>
	                <tbody>
	                    @foreach($tests as $test)
		                    <tr>
		                    <td>{{$test->title}}</td>
		                    <td><h5>
				                    @if($test->is_active)
					                    <span class="badge badge-success">Yes</span>
				                    @else
					                    <span class="badge badge-warning">No</span>
				                    @endif
			                    </h5></td>
		                    <td>
			                    <div class="btn-group btn-group-sm" role="group"
			                         aria-label="Basic example">
								  <a href="{{route('tests.questions.index', $test)}}"
								     class="btn btn-secondary">Questions</a>
								  <a href="{{route("tests.edit", $test)}}"
								     class="btn btn-info">Edit</a>
								  <button type="button"
								          class="btn btn-danger">Delete</button>
								</div>
		                    </td>
	                    </tr>
	                    @endforeach
	                </tbody>
                </table>
            </div>
        </div>
    </div>
	</div>
@endsection