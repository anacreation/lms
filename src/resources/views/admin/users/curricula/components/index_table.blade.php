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
					  <a type="button"
					     href="{{route('')}}"
					     class="btn-primary text-light btn btn-sm">Learning</a>
		            <button type="button"
		                    class="btn btn-sm btn-danger">Delete</button>
	            </td>
	        </tr>
        @endforeach
    </tbody>
</table>