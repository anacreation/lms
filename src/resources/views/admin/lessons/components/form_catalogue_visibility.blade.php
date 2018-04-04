<div class="col-sm-4">
    <label>Is visible in catalogue</label>
    <br>
    <div class="btn-group"
         data-toggle="buttons">
      <label class="btn btn-sm btn-outline-primary  @if(!isset($lesson) or $lesson->is_visible) active @endif">
        <input type="radio" name="is_visible"
               value="1"
               style="display: none"
               autocomplete="off"
               @if(!isset($lesson) or $lesson->is_visible)
               checked
		        @endif> Yes
      </label>
   
      <label class="btn btn-sm btn-outline-warning @if(isset($lesson) and !$lesson->is_visible) active @endif">
        <input type="radio" name="is_visible"
               value="0"
               style="display: none"
               autocomplete="off"
               @if(isset($lesson) and !$lesson->is_visible)
               checked
		        @endif> No
      </label>
    </div>
</div>