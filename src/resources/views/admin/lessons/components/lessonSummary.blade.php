<div class="form-group">
    <label for="content"
           class="col-form-label">Summary</label>
	<ckeditor
			name="summary"
			id="summary"
			:config="ckeditor_summary_config"
			value="{{isset($lesson)?(old('summary')??$lesson->summary):old('summary')}}"
	></ckeditor>
	@if ($errors->has('summary'))
		<span class="invalid-feedback">
            <strong>{{ $errors->first('summary') }}</strong>
        </span>
	@endif
	
	{{--<label for="content"--}}
	{{--class="col-form-label">Summary</label>--}}
	{{--<textarea id="content"--}}
	{{--class="form-control{{ $errors->has('summary') ? ' is-invalid' : '' }}"--}}
	{{--name="summary"--}}
	{{--required>@if(isset($lesson)){{old('summary')??$lesson->summary}}@else{{old('summary')}}@endif</textarea>--}}
	{{--@if ($errors->has('summary'))--}}
	{{--<span class="invalid-feedback">--}}
	{{--<strong>{{ $errors->first('summary') }}</strong>--}}
	{{--</span>--}}
	{{--@endif--}}
</div>