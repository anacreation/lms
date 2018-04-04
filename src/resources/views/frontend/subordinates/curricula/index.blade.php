@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <form action="{{route('users.curricula', $user)}}"
	              method="POST">
		        {{csrf_field()}}
		
		        <div class="card">
			        <div class="card-header bg-primary text-white">
		                Curricula assigned to {{$user->name}}
				        <input type="submit" value="Update Assigned Curricula"
				               class="btn btn-success text-light btn-sm float-right">
	                </div>
				        <table class="table">
						<thead>
							<th>Select</th>
							<th>Curriculum Name</th>
							<th>Status</th>
							<th>Actions</th>
						</thead>
						<tbody>
							@foreach($curricula as $curriculum)
								<tr>
									<td class="pl-4">
                                        <input type="checkbox" name="ids[]"
                                               value="{{$curriculum->id}}"
                                               @if($user->hasCurriculum($curriculum)) checked @endif
                                        >
									</td>
									<td>{{$curriculum->name}}</td>
									<td>
										 @if($user->hasCurriculum($curriculum))
											@if($user->hasCompletedCurriculum($curriculum))
												<span class="badge badge-success">Completed</span>
											@else
												<span class="badge badge-warning">Not complete</span>
											@endif
										@else
											<span class="badge badge-default">Not Assigned</span>
										@endif
									</td>
									<td>
										 @if($user->hasCurriculum($curriculum))
											<a href="{{route("supervisor.show.curriculum.details", [$user, $curriculum])}}"
											   class="btn btn-primary btn-sm text-light">Details</a>
											<a class="btn btn-danger btn-sm text-light">Remove</a>
										@else
											<button class="btn btn-success btn-sm">Assign</button>
										@endif
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