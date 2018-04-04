<div class="form-group">
    <label for="content"
           class="col-form-label">Summary</label>
	<ckeditor
			name="summary"
			id="summary"
			v-model="summary"
			:config="ckeditor_summary_config"></ckeditor>
	@if ($errors->has('summary'))
		<span class="invalid-feedback">
            <strong>{{ $errors->first('summary') }}</strong>
        </span>
	@endif
</div>