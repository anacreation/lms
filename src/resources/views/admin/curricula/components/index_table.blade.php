<table class="table">
    <thead>
        <th>Title</th>
        <th>Actions</th>
    </thead>
    <tbody>
        @foreach($curricula as $curriculum)
	        <tr>
	            <td>{{$curriculum->name}}</td>
	            <td>
					  <a
					     href="{{route('curricula.learnings.index', $curriculum->id)}}"
					     class="btn-primary text-light btn btn-sm">Lessons</a>
		            <button type="button"
		                    class="btn btn-sm btn-danger">Delete</button>
	            </td>
	        </tr>
        @endforeach
    </tbody>
</table>