@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">
	                Course Catalogue
	                <a href="{{route('lessons.create')}}"
	                   class="btn btn-success btn-sm float-right">Create</a>
                </div>

		        <table-actions inline-template>
                <table class="table" ref="table">
                    <thead>
                        <th>Title</th>
                        <th>Is Active</th>
                        <th>Is Featured</th>
                        <th>Visible (Catalogue)</th>
                        <th>Actions</th>
                    </thead>
	                <tbody>
	                    @foreach($lessons as $lesson)
		                    <tr data-id="{{$lesson->id}}">
		                    <td>{{$lesson->title}}</td>
		                    <td><h5>
				                    @if($lesson->is_active)
					                    <span class="badge badge-success">Yes</span>
				                    @else
					                    <span class="badge badge-warning">No</span>
				                    @endif
			                    </h5></td>
		                    <td><h5>
				                    @if($lesson->is_featured)
					                    <span class="badge badge-success">Yes</span>
				                    @else
					                    <span class="badge badge-warning">No</span>
				                    @endif
			                    </h5></td>
			                    
		                    <td><h5>
				                    @if($lesson->is_visible)
					                    <span class="badge badge-success">Yes</span>
				                    @else
					                    <span class="badge badge-warning">No</span>
				                    @endif
			                    </h5></td>
		                    <td>
			                    <div class="btn-group btn-group-sm" role="group"
			                         aria-label="Basic example">
								  <a href="{{route('lessons.enrolled.users', $lesson)}}"
								     class="btn btn-secondary">Users</a>
								  <a href="{{route('lessons.units.index', $lesson)}}"
								     class="btn btn-primary">Units</a>
								  <a href="{{route("lessons.edit", $lesson)}}"
								     class="btn btn-info">Edit</a>
								  <button type="button"
								          @click.prevent="deleteItem('{{route("lessons.destroy", $lesson)}}', removeDom)"
								          class="btn btn-danger">Delete</button>
								</div>
		                    </td>
	                    </tr>
	                    @endforeach
	                </tbody>
                </table>
			        </table-actions>
            </div>
        </div>
    </div>
	</div>
@endsection