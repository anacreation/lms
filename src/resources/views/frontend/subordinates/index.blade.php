@extends("lms::layouts.app")

@section("content")
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @if (session('status'))
		        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
	        @endif
	        <div class="card">
                <div class="card-header bg-primary text-white">
	                Subordinates
                </div>

                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Actions</th>
                    </thead>
	                <tbody>
	                @foreach($subordinates as $user)
		                <tr>
		                    <td>{{$user->name}}</td>
		                    <td>
			                    <div class="btn-group btn-group-sm" role="group"
			                         aria-label="Basic example">
								  <a class="btn btn-primary"
								     href="{{route("users.curricula", $user)}}">Curricula</a>
								  <a href="{{route("users.show", $user)}}"
								     class="btn btn-info">Show</a>
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