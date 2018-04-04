<div class="form-group">
	
    <label for="content"
           class="col-form-label">Cover Pic</label>
	@if(isset($lesson))
		<img class="img-fluid mb-3"
		     src="{{$lesson->getFirstMediaUrl('coverPic')}}">
	@endif
	<input type="file" class="form-control" id="coverPic"
	       name="coverPic">
	
	@if ($errors->has('coverPic'))
		<span class="invalid-feedback">
            <strong>{{ $errors->first('coverPic') }}</strong>
        </span>
	@endif
</div>