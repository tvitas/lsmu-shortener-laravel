@extends('layouts.backend')

@section('content')

<div class="uk-container uk-margin-bottom" uk-height-viewport="offset-top: true">
<div class="uk-card uk-card-default uk-card-body">

<h2 class="uk-card-header">{{ __('Shorts') }} {{ __('edit') }}</h2>

@include('partials.form_errors')
@include('partials.messages')

<form class="uk-form" action="{{ route('admin.shorts.edit.save', ['id' => $short->id]) }}" method="POST">
@csrf
@method('put')

<div class="uk-margin-bottom uk-width-1-1">
<label>{{ __('URL') }}</label>
<input class="uk-input" type="text" name="url" id="url" value="{{ $short->url }}" placeholder="{{ __('URL') }}">
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<h5>{{ __('Short URL') }}</h5>
<a class="uk-text-danger" href="{{ request()->getSchemeAndHttpHost()}}/{{ $short->identifier }}">{{ request()->getSchemeAndHttpHost()}}/{{ $short->identifier }}</a>
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-2@m">
<label>{{ __('Tags') }}</label>
<input class="uk-input" name="tags" value="{{ $short->tags }}">
</div>


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<input type="hidden" name="active" value="0">
<label><input class="uk-checkbox" type="checkbox" name="active" value="1" @if ($short->active) checked @endif> {{ __('Active') }}</label>
</div>


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<label>{{ __('Short URL expires on') }}</label>
<input class="uk-input" type="text" name="expires" value="{{ $short->expires }}">
</div>

<div class="uk-margin-bottom">
@include('partials.share_edit_accordion')
</div>


<button class="uk-button uk-button-primary" type="submit">{{ __('Save') }}</button>
<a class="uk-button uk-margin uk-button-danger" href="{{ route('admin.shorts.index', ['page' => session()->get('page', 1)]) }}">{{ __('Cancel') }}</a>
</form>

</div>
</div>

@endsection

