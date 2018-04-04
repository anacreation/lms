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
				        {{$user->name}}
				        in curriculum {{$curriculum->title}}
	                </div>
				        <table class="table">
						<thead>
							<th>Lesson Name</th>
							<th>Status</th>
						</thead>
						<tbody>
							@foreach($curriculum->items as $learningItem)
								<tr>
									<td>{{$learningItem->learning->getName()}}</td>
									<td>
										{!! optional($user->getLatestStatusForLesson($learningItem->learning))->displayStatus()!!}
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