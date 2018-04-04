@extends("lms::layouts.app")

@section("content")
	
	
	<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mb-3">
	        @include("lms::admin.components.alert")
	        <div class="card">
                <div class="card-header bg-primary text-white">New Course</div>
		        
		        <div class="card-body">
			         <lesson-edit-form :tests="{{$tests}}"
			                           :old-inputs="{{json_encode(old())}}"
			                           inline-template>
				         <div>
					         <form action="{{route('lessons.store')}}"
					               method="POST"
					               @submit.prevent="submit"
					               enctype="multipart/form-data">
	                
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
						
						         @include("lms::admin.lessons.components.form_completion_criteria")
						
						         <div class="form-group">
							          <div class="row">
						        @include("lms::admin.lessons.components.form_catalogue_visibility")
								
								          @include("lms::admin.lessons.components.form_is_active")
								
								          @include("lms::admin.lessons.components.form_is_featured")
					        </div>
						          </div>
						         <div class="form-group">
							        <select-prerequisites
									        ref="prerequisite_form"
									        :options="{{json_encode(Anacreation\Lms\Models\Lesson::get(['title','id'])->toArray())}}"
									        :selected="{{json_encode(old('prerequisites')??[])}}"
							        ></select-prerequisites>
							         @if ($errors->has('prerequisites'))
								         <span class="invalid-feedback">
		                                    <strong>{{ $errors->first('prerequisites') }}</strong>
		                                </span>
							         @endif
						        </div>
						
						         @include("lms::admin.lessons.components.coverPic")
						         @include("lms::admin.lessons.components.lessonSummary")
						         <div class="form-group">
							         <label>Tags</label>
							         <vue-select taggable
							                     v-model="tags"
							                     :options="{{$tags}}"
							                     multiple></vue-select>
						         </div>
						         @include("lms::admin.lessons.components.lessonContents")
						
						         <div class="form-group">
	                                <button type="submit"
	                                        class="btn btn-success">
	                                    Create
	                                </button>

	                                <a class="btn btn-link btn-outline-primary"
	                                   href="{{ route('lessons.index') }}">
	                                    Back
	                                </a>
                                </div>
	                        </form>
					         <div class="modal fade" id="exampleModal"
					              tabindex="-1"
					              role="dialog"
					              aria-labelledby="exampleModalLabel"
					              aria-hidden="true">
						         <div class="modal-dialog" role="document">
						              <form @submit.prevent="submitToCreateTest">
					                    <div class="modal-content">
						                  <div class="modal-header">
						                    <h5 class="modal-title"
						                        id="exampleModalLabel">New Test</h5>
						                    <button type="button" class="close"
						                            data-dismiss="modal"
						                            aria-label="Close">
						                      <span aria-hidden="true">&times;</span>
						                    </button>
						                  </div>
						                  <div class="modal-body">
							                  
							                  <div class="form-group">
				                                <label for="title"
				                                       class="col-form-label">Title</label>
				
				                                <input id="title"
				                                       class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
				                                       name="title"
				                                       v-model="testForm.title"
				                                       required autofocus>
								
									                  <span class="invalid-feedback"
									                        v-if="testFormErrors['title']">
				                                        <strong v-text="testFormErrors['title'][0]"></strong>
				                                    </span>
				                            </div>
							             
							                <div class="form-group">
								              <label>Is Active</label>
								              <br>
								              <div class="btn-group"
								                   data-toggle="buttons">
									              <label class="btn btn-sm btn-outline-primary active">
										              <input type="radio"
										                     name="is_active"
										                     value="1"
										                     style="display: none"
										                     :checked="testForm.is_active"
										                     autocomplete="off"> Active
									              </label>
									              <label class="btn btn-sm btn-outline-warning">
													  <input type="radio"
													         name="is_active"
													         value="0"
													         style="display: none"
													         :checked="!testForm.is_active"
													         autocomplete="off"> No
									              </label>
								              </div>
							              </div>
							              <div class="form-group">
								              <label for="passing_rate">Passing Rate % (Score over this rate)</label>
								              <br>
								              <div class="input-group mb-3">
												  <input type="number"
												         class="form-control"
												         name="passing_rate"
												         v-model="testForm.passing_rate"
												         aria-label="Test passing rate in percentage" />
												  <div class="input-group-append">
												    <span class="input-group-text">%</span>
												  </div>
												</div>
								              <span class="invalid-feedback"
								                    v-if="testFormErrors['passing_rate']">
			                                    <strong v-text="testFormErrors['passing_rate'][0]"></strong>
			                                </span>
								             
							              </div>
						                  
						                  </div>
						                  <div class="modal-footer">
						                    <button type="button"
						                            class="btn btn-sm btn-secondary"
						                            onclick="return false"
						                            data-dismiss="modal">Close</button>
						                    <button type="submit"
						                            class="btn btn-sm btn-primary">Create</button>
						                  </div>
						                </div>
						              </form>
					              </div>
					         </div>
				         </div>
			         </lesson-edit-form>
			        
		        </div>
            </div>
        </div>
    </div>
	</div>
@endsection