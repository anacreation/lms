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
	                Users
	                <a href="{{route('users.create')}}"
	                   class="btn btn-success btn-sm float-right">Add User</a>
                </div>

                <table class="table">
                    <thead>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </thead>
	                <tbody>
	                @foreach($users as $user)
		                <tr>
		                    <td>{{$user->name}}</td>
		                    <td><h5>{!! $user->displayRoles("<span class=\"badge badge-info m-1\">%s</span>") !!}</h5></td>
		                    <td>
			                    <div class="btn-group btn-group-sm" role="group"
			                         aria-label="Basic example">
								  <a class="btn btn-primary"
								     href="{{route("users.curricula", $user)}}">Curricula</a>
								  <a href="{{route("users.edit", $user)}}"
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