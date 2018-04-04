<mc-form
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
					             <input class="form-control"
					                    name="question_type_id"
					                    type="hidden"
					                    value="1"
					             >
				             </div>
					        
				             <div class="form-group">
					              <label>Question Content</label>
					              <ckeditor name="content"
					                        id="content"></ckeditor>
				             </div>
				             <div class="form-group">
					              <label>Required All</label>
					              <br>
					             <div class="btn-group btn-group-toggle"
					                  data-toggle="buttons">
									  <label class="btn btn-sm btn-outline-success active">
									    <input type="radio"
									           name="is_required_all"
									           value="1"
									           autocomplete="off"
									           checked
									    > True
									  </label>
									  <label class="btn btn-sm btn-outline-warning ">
									    <input type="radio"
									           name="is_required_all"
									           value="0"
									           autocomplete="off"
									    > False
									  </label>
									</div>
				              </div>
					        <div class="form-group">
						        <button class="btn btn-primary"
						                @click.prevent="addChoice()">Add Choice</button>
					        </div>
				             
				             <mc-choice v-for="(choice, index) in choices"
				                        :id="index"
				                        :key="index"
				                        v-on:remove-choice="removeChoice"
				                        :choice="choice"></mc-choice>
					        
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
			        </mc-form>