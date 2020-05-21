@extends('layouts.backend')

@section('content')

<div class="uk-container uk-margin-bottom" uk-height-viewport="offset-top: true">
<div class="uk-card uk-card-default uk-card-body">

<h2 class="uk-card-header">{{ __('Shorts') }} {{ __('add') }}</h2>

@include('partials.form_errors')
@include('partials.messages')

<form class="uk-form" action="{{ route('admin.shorts.add.save') }}" method="POST">
@csrf

<div class="uk-inline uk-margin-bottom uk-width-1-1">
<button type="button" id="url-generate" class="uk-form-icon uk-form-icon-flip uk-button-primary" uk-icon="icon: link"></button>
<input class="uk-input" type="text" name="url" id="url" value="{{ request()->old('url') }}" placeholder="{{ __('URL to be shortened') }}">
</div>

<input class="uk-input" type="hidden" name="identifier" id="identifier" value="{{ request()->old('identifier') }}">


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<p class="uk-text-danger">{{ __('Short URL') }}: <span id="genurl"></span></p>
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-2@m">
<label>{{ __('Tags') }}</label>
<input class="uk-input" name="tags" value="{{ request()->old('tags') }}">
</div>


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<input type="hidden" name="active" value="0">
<label><input class="uk-checkbox" type="checkbox" name="active" value="1"> {{ __('Active') }}</label>
</div>


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<label>{{ __('Short URL expires on') }}</label>
<input class="uk-input" type="text" name="expires" value="{{ $expires }}">
</div>

@include('partials.share_add_accordion')


<button class="uk-margin uk-button uk-button-primary" type="submit">{{ __('Add') }}</button>
<a class="uk-button uk-margin uk-button-danger" href="{{ route('admin.shorts.index', ['page' => session()->get('page', 1)]) }}">{{ __('Cancel') }}</a>
</form>



</div>
</div>

@endsection

@section('scripts')
<script>
$('#url').on('change', function() {
	return genShort();
});
$('#url-generate').on('click', function(e) {
	e.preventDefault();
	return genShort();
});
function genShort() {
	//randomStr = Math.random().toString(36).substring(2, 8) + Math.random().toString(36).substring(2, 8);
	randomStr = [...Array(10)].map(i=>(~~(Math.random()*36)).toString(36)).join('');
	host = location.host;
	protocol = location.protocol;
	shortUrl = protocol + '//' + host + '/' + randomStr;
	$('#genurl').html(shortUrl);
	$('#identifier').val(randomStr);	
}
</script>
@endsection