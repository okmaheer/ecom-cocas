<div class="form-group">
    <label class="control-label">Image 1 (540x300)</label>
    {!! Form::mediaImage('image1', Arr::get($attributes, 'image1')) !!}
</div>

<div class="form-group">
    <label class="control-label">URL 1</label>
    <input type="text" name="url1" value="{{ Arr::get($attributes, 'url1') }}" class="form-control" placeholder="URL 1">
</div>

<div class="form-group">
    <label class="control-label">Image 2 (540x300)</label>
    {!! Form::mediaImage('image2', Arr::get($attributes, 'image2')) !!}
</div>

<div class="form-group">
    <label class="control-label">URL 2</label>
    <input type="text" name="url2" value="{{ Arr::get($attributes, 'url2') }}" class="form-control" placeholder="URL 2">
</div>

<div class="form-group">
    <label class="control-label">Image 3 (540x300)</label>
    {!! Form::mediaImage('image3', Arr::get($attributes, 'image3')) !!}
</div>

<div class="form-group">
    <label class="control-label">URL 3</label>
    <input type="text" name="url3" value="{{ Arr::get($attributes, 'url3') }}" class="form-control" placeholder="URL 3">
</div>
