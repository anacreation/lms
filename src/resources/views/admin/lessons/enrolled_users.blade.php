@extends("lms::layouts.app")

@section("content")
	<div class="container justify-content-center">
		<div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
			<div class="card">
                <div class="card-header bg-primary text-white">
	                Enrolled Users
                </div>

                <table class="table">
                    <thead>
                        <th>User Name</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </thead>
	                <tbody>
	                    @foreach($lesson->enrollments as $enrollment)
		                    <tr>
		                    <td>{{$enrollment->user->name}}</td>
		                    <td>
			                    {!! $enrollment->user->getLatestStatusForLesson($lesson)->displayStatus() !!}
							</td>
		                    <td>
			                    <div class="btn-group btn-group-sm" role="group"
			                         aria-label="Basic example">
				                    @if($lesson->isCompletedBy(\Anacreation\Lms\Enums\CompletionType::Test))
					                    <a href="{{route("lessons.users.attempts", [$lesson, $enrollment->user])}}"
					                       class="btn btn-info">Attempts</a>
				                    @endif
				                    <a href="{{route("lessons.users.reenabled", [$lesson, $enrollment->user])}}"
				                       class="btn btn-primary">Re-Enable</a>
				                     <button type="button"
				                             class="btn btn-danger">Remove</button>
								</div>
		                    </td>
	                    </tr>
	                    @endforeach
	                </tbody>
                </table>
            </div>
        </div>
	</div>
@endsection