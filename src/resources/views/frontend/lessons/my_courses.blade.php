@extends("lms::layouts.app")

@section("content")
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">
	                My Courses
                </div>
		        <div class="card-body">
			         @foreach($user->getAssignedCurricula() as $curriculum)
				        <section>
			            <h4>{{$curriculum->name}} Courses:</h4>
				        <table class="table">
					        <thead>
		                        <th>Lesson Name</th>
		                        <th>Status</th>
		                    </thead>
					         <tbody>
				                @foreach($curriculum->items as $learning)
					                <tr>
					                    <td>
						                    <a href="{{route("lessons.show", $learning->learning)}}">{{$learning->learning->getName()}}</a>
					                    </td>
					                    <td>
						                    @if($status = $user->getLatestStatusForLesson($learning->learning))
							                    {!! $status->displayStatus() !!}
						                    @else
							                    <span class="badge badge-secondary">Not Enrolled yet</span>
						                    @endif
					                    </td>
				                    </tr>
				                @endforeach
			                </tbody>
				        </table>
		            </section>
			        @endforeach
			
			        <section>
			            <h4>Other enrolled courses:</h4>
			
				        <table class="table">
		                    <thead>
		                        <th>Lesson Name</th>
		                        <th>Status</th>
				        </thead>
				        <tbody>
			                @foreach($lessonStatus as $status)
				                <tr>
				                    <td>
					                    <a href="{{route("lessons.show", $status->first()->lesson)}}">{{$status->first()->lesson->getName()}}</a>
				                    </td>
				                    <td>{!! $status->first()->displayStatus() !!}</td>
			                    </tr>
			                @endforeach
			                </tbody>
				        </table>
		            </section>
		        </div>
		        
		
		       
		        
			
			       
            </div>
        </div>
    </div>
	</div>
@endsection