@extends("lms::layouts.app")

@section("content")
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				@include("lms::frontend.lessons.components.tag_list")
			</div>
			<div class="col-sm-9">
				<div class="row">
					@foreach($lessons as $lesson)
						<div class="col-sm-6 col-md-4">
							@include("lms::frontend.lessons.components.lesson_card", compact("lesson"))
						</div>
					@endforeach
				</div>
				
			</div>
		</div>
	</div>
@endsection