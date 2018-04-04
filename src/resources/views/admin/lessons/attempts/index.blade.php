@extends("lms::layouts.app")

@section("content")
	<div class="container justify-content-center">
		<div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
			<div class="card">
                <div class="card-header bg-primary text-white">
	                User Test Attempts for Lesson: {{$lesson->title}} (Passing Rate: {{sprintf("%.0f", $test->passing_rate)}}
	                %)
                </div>

                <table class="table">
                    <thead>
                        <th>Number</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Submission Datetime</th>
                        <th>Actions</th>
                    </thead>
	                <tbody>
	                    @foreach($attempts as $index=>$attempt)
		                    <tr>
		                    <td>{{count($attempts)-$index}}</td>
		                    <td>{{sprintf("%.0f", $attempt->score * 100)}}%</td>
		                    <td>
								@if($test->passed($attempt))
				                    <span class="badge badge-success">Passed</span>
			                    @else
				                    <span class="badge badge-warning">Failed</span>
			                    @endif
							</td>
		                    <td>
								{{$attempt->created_at->diffForHumans()}}
							</td>
		                    <td>
			                    <div class="btn-group btn-group-sm" role="group"
			                         aria-label="Basic example">
								  <a href="{{route("lessons.users.attempts.detail", [$lesson,$user,$attempt])}}"
								     class="btn btn-info">Detail</a>
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