<div class="form-group">
    <label>Complete the lesson by</label>
    <br>
    <div class="btn-group" data-toggle="buttons">
  <label class="btn btn-sm btn-outline-primary"
         :class="{'active':completionType=='2'}"
         @click="updateCompletionType('2')">
    <input type="radio" name="completion_criteria"
           value="2"
           style="display: none"
           autocomplete="off"
           :checked="completionType==2"
    /> Click
  </label>

  <label class="btn btn-sm btn-outline-success"
         :class="{'active':completionType=='0'}"
         @click="updateCompletionType('0')">
    <input type="radio" name="completion_criteria"
           value="0"
           style="display: none"
           autocomplete="off"
           :checked="completionType==0"
    /> Test
  </label>
  <label class="btn btn-sm btn-outline-info"
         :class="{'active':completionType=='1'}"
         @click="updateCompletionType('1')">
    <input type="radio" name="completion_criteria"
           value="1"
           style="display: none"
           autocomplete="off"
           :checked="completionType==1"
    /> Time
  </label>
</div>
</div>

<div class="row" v-show="showSelectTest">
    <div class="col-10">
        <div class="form-group">
           <label>Completed By Pass Test</label>
            <vue-select label="title"
                        v-model="selectedTest"
                        :options="tests">
             </vue-select>
	        @if ($errors->has('test_id'))
		        <span class="invalid-feedback">
                        <strong>{{ $errors->first('test_id') }}</strong>
                    </span>
	        @endif
        </div>
        <div class="form-group">
            <button class="btn btn-success" onclick="return false" data-toggle="modal" data-target="#exampleModal">Create New Test</button>
        </div>
    </div>
    <div class="col-2">
        <div class="form-group" v-show="showSelectTest">
           <label>Max Attempts</label>
                <input type="number" class="form-control" min="0" step="1"
                       value="{{isset($lesson)? (old("max_attempts")??$lesson->completionCriteria->max_attempts):old("max_attempts")}}"
                       name="max_attempts"
                       placeholder="0 is unlimited"
                />
	        </vue-select>
	        @if ($errors->has('max_attempts'))
		        <span class="invalid-feedback">
                        <strong>{{ $errors->first('max_attempts') }}</strong>
                    </span>
	        @endif
        </div>
    </div>
</div>


<div class="form-group" v-show="showTimer">
   <label>Completed after how many seconds</label>
    <input class="form-control" type="number"
           :value="seconds"
           min="1" step="1" name="seconds">
	@if ($errors->has('seconds'))
		<span class="invalid-feedback">
                <strong>{{ $errors->first('seconds') }}</strong>
            </span>
	@endif
</div>