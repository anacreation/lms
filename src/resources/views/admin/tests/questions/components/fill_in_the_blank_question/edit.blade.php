<mc-form
		:question="{{$question}}"
		redirect-url="{{route("tests.questions.index", $test)}}"
		inline-template>
				        <form action="{{route('tests.questions.update', [$test, $question])}}"
				              method="POST"
				              @submit.prevent="submit">
		                    {{csrf_field()}}
					        {{method_field("PUT")}}
					
					        <div class="form-group">
					              <label>Is Active</label>
					              <br>
					             <div class="btn-group btn-group-toggle"
					                  data-toggle="buttons">
									  <label class="btn btn-sm btn-outline-success
									  @if($question->is_active)
											  active
											  @endif">
									    <input type="radio"
									           name="is_active"
									           value="1"
									           autocomplete="off"
									           @if($question->is_active)
									           checked
											    @endif
									    > Active
									  </label>
									  <label class="btn btn-sm btn-outline-warning  @if(!$question->is_active)
											  active
											  @endif">
									    <input type="radio"
									           name="is_active"
									           value="0"
									           autocomplete="off"
									           @if(!$question->is_active)
									           checked
											    @endif
									    > NO
									  </label>
									</div>
				              </div>
				             
				             
				             <div class="form-group">
					             <input class="form-control"
					                    name="question_type_id"
					                    type="hidden"
					                    value="1"
					             >
				             </div>
					        
				             <div class="form-group">
					              <label>Question Content</label>
					              <ckeditor name="content"
					                        :value="{{json_encode($question->content)}}"
					                        id="content"></ckeditor>
				             </div>
				              <div class="form-group">
					             <label>Answer</label>
					             <input type="text" class="form-control"
					                    value="{{ $question->choices->first()->content }}"
					                    name="choices[0][content]" />
					             <input type="hidden" name="choices[0][id]"
					                    value="{{ $question->choices->first()->id }}" />
					             <input type="hidden" name="choices[0][type]"
					                    value="_db" />
					             <input type="hidden" name="choices[0][active]"
					                    value="1" />
					             <input type="hidden"
					                    name="choices[0][is_corrected]"
					                    value="1" />
					             <input type="hidden"
					                    name="is_required_all"
					                    value="1" />
				             </div>
					        
				            <div class="form-group">
                                <button type="submit" class="btn btn-success">
                                    Update
                                </button>

                                <a class="btn btn-link btn-outline-primary"
                                   href="{{ route('tests.questions.index',[$test,$question]) }}">
                                    Back
                                </a>
                        </div>
	                </form>
			        </mc-form>