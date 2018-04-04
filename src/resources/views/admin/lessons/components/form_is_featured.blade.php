<div class="col-sm-2">
    <label>Is Featured</label>
    <br>
    <div class="btn-group"
         data-toggle="buttons">
      <label class="btn btn-sm btn-outline-primary  @if(isset($lesson) and $lesson->is_featured)active @endif">
        <input type="radio" name="is_featured"
               value="1"
               style="display: none"
               autocomplete="off"
               @if(isset($lesson) and $lesson->is_featured)
               checked
		        @endif> Yes
      </label>
   
      <label class="btn btn-sm btn-outline-warning @if(!isset($lesson) or !$lesson->is_featured)active @endif">
        <input type="radio" name="is_featured"
               value="0"
               style="display: none"
               autocomplete="off"
               @if(!isset($lesson) or !$lesson->is_featured)
               checked
		        @endif> No
      </label>
    </div>
</div>