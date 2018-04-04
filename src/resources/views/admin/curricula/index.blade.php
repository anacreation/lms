@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">
	                Curricula
	                <a href="{{route('curricula.create')}}"
	                   class="btn btn-success btn-sm float-right">Create Curriculum</a>
                </div>

                @include("lms::admin.curricula.components.index_table", compact('curricula'))
            </div>
        </div>
    </div>
	</div>
@endsection