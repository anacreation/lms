<div class="form-group">
    <label for="content"
           class="col-form-label">Content</label>
	<ckeditor
			name="content"
			id="content"
			:config="ckeditor_content_config"
			v-model="content"></ckeditor>
       <input type="hidden" value="Text" name="content-type">
	@if ($errors->has('content'))
		<span class="invalid-feedback">
            <strong>{{ $errors->first('content') }}</strong>
        </span>
	@endif
	{{--<label for="content"--}}
	{{--class="col-form-label">Content</label>--}}
	{{--<textarea id="content"--}}
	{{--class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}"--}}
	{{--name="content"--}}
	{{--required>@if(isset($content)){{old('content')??$content->content->show()}}@else{{old('content')}}@endif</textarea>--}}
	{{--<input type="hidden" value="Text" name="content-type">--}}
	{{--@if ($errors->has('content'))--}}
	{{--<span class="invalid-feedback">--}}
	{{--<strong>{{ $errors->first('content') }}</strong>--}}
	{{--</span>--}}
	{{--@endif--}}
</div>