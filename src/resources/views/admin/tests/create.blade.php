@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">New Test</div>
		        
		        <div class="card-body">
			             <form action="{{route('tests.store')}}" method="POST">
		                {{csrf_field()}}
				
				             <div class="form-group">
	                            <label for="title"
	                                   class="col-form-label">Title</label>
	
	                                <input id="title"
	                                       class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
	                                       name="title"
	                                       value="{{ old('title') }}"
	                                       required autofocus>
					
					             @if ($errors->has('title'))
						             <span class="invalid-feedback">
	                                        <strong>{{ $errors->first('title') }}</strong>
	                                    </span>
					             @endif
	                </div>
				             
				              <div class="form-group">
					              <label>Is Active</label>
					              <br>
					              <div class="btn-group"
					                   data-toggle="buttons">
						              <label class="btn btn-sm btn-outline-primary active">
							              <input type="radio" name="is_active"
							                     value="1"
							                     style="display: none"
							                     autocomplete="off" checked> Active
						              </label>
						              <label class="btn btn-sm btn-outline-warning">
										  <input type="radio"
										         name="is_active"
										         value="0"
										         style="display: none"
										         autocomplete="off"> No
						              </label>
					              </div>
				              </div>
				              <div class="form-group">
					              <label>Passing Rate % (Score over this rate)</label>
					              <br>
					              <div class="input-group mb-3">
									  <input type="number" class="form-control"
									         name="passing_rate"
									         value="{{old("passing_rate")}}"
									         aria-label="Test passing rate in percentage">
									  <div class="input-group-append">
									    <span class="input-group-text">%</span>
									  </div>
									</div>
					              @if ($errors->has('passing_rate'))
						              <span class="invalid-feedback">
	                                        <strong>{{ $errors->first('passing_rate') }}</strong>
	                                    </span>
					              @endif
					             
				              </div>
				        
				
				
				            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    Create
                                </button>

                                <a class="btn btn-link btn-outline-primary"
                                   href="{{ route('tests.index') }}">
                                    Back
                                </a>
                        </div>
	                </form>
		        </div>
            </div>
        </div>
    </div>
	</div>
@endsection