<fill-in-blank-form
		redirect-url="{{route('tests.questions.index', $test)}}"
		inline-template>
				        <form action="{{route('tests.questions.store', $test)}}"
				              method="POST" @submit.prevent="submit">
		                {{csrf_field()}}
					
					        <div class="form-group">
					              <label>Is Active</label>
					              <br>
					             <div class="btn-group btn-group-toggle"
					                  data-toggle="buttons">
									  <label class="btn btn-sm btn-outline-success active">
									    <input type="radio"
									           name="is_active"
									           value="1"
									           autocomplete="off"
									           checked
									    > Active
									  </label>
									  <label class="btn btn-sm btn-outline-warning">
									    <input type="radio"
									           name="is_active"
									           value="0"
									           autocomplete="off"
									    > NO
									  </label>
									</div>
				              </div>
					        
				             <div class="form-group">
					              <label>Question Content</label>
					              <ckeditor name="content"
					                        id="content"></ckeditor>
				             </div>
				             
				             <div class="form-group">
					             <label>Answer</label>
					             <input class="form-control"
					                    name="question_type_id"
					                    type="hidden"
					                    value="2"
					             />
					             <input type="text" class="form-control"
					                    name="choices[1][content]" />
					             <input type="hidden" name="choices[1][id]" />
					             <input type="hidden" name="choices[1][type]"
					                    value="new" />
					             <input type="hidden" name="choices[1][active]"
					                    value="1" />
					             <input type="hidden"
					                    name="choices[1][is_corrected]"
					                    value="1" />
					             <input type="hidden"
					                    name="is_required_all"
					                    value="1" />
				             </div>
					        
				            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    Create
                                </button>
                                <button type="submit" class="btn btn-primary"
                                        @click="refresh=true">
                                    Create and New
                                </button>

                                <a class="btn btn-link btn-outline-primary"
                                   href="{{ route('tests.questions.index', $test) }}">
                                    Back
                                </a>
                        </div>
	                </form>
			        </fill-in-blank-form>