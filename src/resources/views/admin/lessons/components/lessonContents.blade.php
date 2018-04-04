<div class="form-group">
    <label for="content"
           class="col-form-label">Content</label>
	<ckeditor
			name="content"
			id="content"
			value="{{isset($content)?(old('content')??$content->content->content):old('content')}}"
			:config="ckeditor_content_config"
	></ckeditor>
       <input type="hidden" value="Text" name="content-type">
	@if ($errors->has('content'))
		<span class="invalid-feedback">
            <strong>{{ $errors->first('content') }}</strong>
        </span>
	@endif
</div>