<h4>Categories</h4>
<form>
	<ul class="list-unstyled">
		@foreach(Anacreation\Lms\Models\Tag::all() as $tag)
			<li>
				<label>
					<input type="checkbox" value="{{$tag->name}}">
					{{$tag->name}}
				</label>
			</li>
		@endforeach
	</ul>
	<button class="btn btn-primary btn-sm">Filter</button>
</form>