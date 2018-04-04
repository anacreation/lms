<div class="col-sm-2">
    <label>Is active</label>
    <br>
    <div class="btn-group"
         data-toggle="buttons">
      <label class="btn btn-sm btn-outline-primary  @if(!isset($lesson) or $lesson->is_active)active @endif">
        <input type="radio" name="is_active"
               value="1"
               style="display: none"
               autocomplete="off"
               @if(!isset($lesson) or $lesson->is_active)
               checked
		        @endif> Yes
      </label>
   
      <label class="btn btn-sm btn-outline-warning @if(isset($lesson) and !$lesson->is_active)active @endif">
        <input type="radio" name="is_active"
               value="0"
               style="display: none"
               autocomplete="off"
               @if(isset($lesson) and !$lesson->is_active)
               checked
		        @endif> No
      </label>
    </div>
</div>