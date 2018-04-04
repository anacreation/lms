@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <form action="{{route('curricula.learnings.store', $curriculum->id)}}"
	              method="POST">
		        {{csrf_field()}}
		
		
		        <div class="card">
                <div class="card-header bg-primary text-white">
	                Learning in: {{$curriculum->name}}
	                <input type="submit" value="Update"
	                       class="btn btn-success text-light btn-sm float-right">
                </div>
			
			
			        @foreach($learningCollection as $key=>$collection)
				        <div class="card-body"><h4>{{$key}}</h4></div>
				        <table class="table">
						<thead>
							<th>Select</th>
							<th>Name</th>
						</thead>
						<tbody>
							@foreach($collection as $item)
								<tr>
									<td class="pl-4">
                                        <input type="checkbox" name="ids[]"
                                               value="{{$key}}_{{$item->id}}"
                                               @if(isset($learningIndices)? in_array($key."_".$item->id, $learningIndices):false)
                                               checked
		                                        @endif
                                        >
									</td>
									<td>{{$item->getName()}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
			        @endforeach
            </div>
	        </form>
        </div>
    </div>
	</div>
@endsection