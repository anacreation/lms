@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">New Course</div>
		        <div class="card-body">
			        <lesson-edit-form inline-template
			                          :lesson="{{($unit)}}"
			                          :tests="{{$tests}}"
			                          :old-inputs="{{json_encode(old())}}"
			        >
			            <form action="{{route('lessons.units.update', [$lesson, $unit])}}"
			                  method="POST" @submit.prevent="submit"
			                  enctype="multipart/form-data">
				        {{method_field("PUT")}}
				
				            {{csrf_field()}}
				
				            <div class="form-group">
	                            <label for="title"
	                                   class="col-form-label">Title</label>
	
	                                <input id="title"
	                                       class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
	                                       name="title"
	                                       value="{{ old('title')??$unit->title }}"
	                                       required autofocus>
					
					            @if ($errors->has('title'))
						            <span class="invalid-feedback">
	                                        <strong>{{ $errors->first('title') }}</strong>
	                                    </span>
					            @endif
	                </div>
				
				            @include("lms::admin.lessons.components.form_completion_criteria")
				
				            <div class="form-group">
						        <div class="row">
							        @include("lms::admin.lessons.components.form_is_active")
						        </div>
					        </div>
				
				            @foreach($unit->contents as $content)
					            @include("lms::admin.lessons.components.lessonContents")
				            @endforeach
				
				
				            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    Update
                                </button>

                                <a class="btn btn-link btn-outline-primary"
                                   href="{{ route('lessons.units.index', $lesson) }}">
                                    Back
                                </a>
                        </div>
	                </form>
			        </lesson-edit-form>
		        </div>
            </div>
        </div>
    </div>
	</div>
@endsection