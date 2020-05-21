@extends('layouts.backend')

@section('content')

<div class="uk-container uk-margin-bottom"  uk-height-viewport="offset-top: true">
<div class="uk-card uk-card-default uk-card-body">

<h2 class="uk-card-header">{{ __('Shorts') }} {{ __('view') }}</h2>

@include('partials.form_errors')
@include('partials.messages')

<div class="uk-grid-small uk-child-width-1-1@s uk-child-width-1-2@m uk-margin-bottom" uk-grid="masonry: true">

<div>
<div class="uk-card uk-card-default uk-card-body uk-card-hover">
<h4 class="uk-card-header">{{ __('URL') }}</h4>
<ul class="uk-list">
<li>{{ $short->url }}</li>
<li><a class="uk-link-reset" href="{{ request()->getSchemeAndHttpHost()}}/{{ $short->identifier }}" target="_blank">{{ request()->getSchemeAndHttpHost()}}/{{ $short->identifier }}</a></li>
</ul>
</div>
</div>

<div>
<div class="uk-card uk-card-default uk-card-body uk-card-hover"> 
<h4 class="uk-card-header">{{ __('Qr samples') }}</h4>
<h5 class="uk-text-center">{{ __('Original URL') }}</h5>
<figure class="uk-text-center">
<img width="150" height="150" src="{{ $qrOriginal }}">
</figure>
<h5 class="uk-text-center">{{ __('Short URL') }}</h5>
<figure class="uk-text-center">
<img width="150" height="150" src="{{ $qrShort }}">
</figure>
</div>
</div>

<div>
<div class="uk-card uk-card-default uk-card-body uk-card-hover">
<h4 class="uk-card-header">{{ __('Download') }}</h4>
<form id="download-form" action="{{ route('admin.shorts.download', ['id' => $short->id]) }}" method="POST">
@csrf

<div uk-grid class="uk-child-width-1-1@s uk-child-width-1-2@m">

<fieldset class="uk-fieldset">
<h5>{{ __('Size') }} <output id="size_out">150</output>&times;<output id="size_out_out">150</output></h5>
<input class="uk-width-1-1 uk-margin" id="size_in" type="range" name="size" value="150" min="100" max="600" step="50" oninput="size_out.value = size_in.value;size_out_out.value = size_in.value">
</fieldset>

<fieldset class="uk-fieldset">
<h5>{{ __('Format') }}</h5>
<div class="uk-margin-bottom">
<label><input type="checkbox" class="uk-checkbox uk-margin-right" name="format[]" value="svg" checked>SVG</label>
</div>
<div class="uk-margin-bottom">
<label><input type="checkbox" class="uk-checkbox uk-margin-right" name="format[]" value="png" checked>PNG</label>
</div>

<div class="uk-margin-bottom">
<label><input type="checkbox" class="uk-checkbox uk-margin-right" name="format[]" value="eps" checked>EPS</label>
</div>
</fieldset>
</div>

<label>{{ __('File name prefix') }}</label>
<input class="uk-input" type="text" name="file_prefix" value="{{ $short->identifier }}" placeholder="{{ __('File name prefix') }}">

</form>
</div>
</div>
</div>

<div class="uk-margin">
<a class="uk-button uk-button-primary" href="{{ route('admin.shorts.index', ['page' => session()->get('page', 1)]) }}">{{ __('Back') }}</a>
<button id="download-button" type="button" class="uk-button uk-button-secondary">{{ __('Download') }}</button>
</div>

</div>
</div>


@endsection

@section('scripts')
<script type="text/javascript">
$('#download-button').on('click', function() {
	$('#download-form').submit();
})
</script>
@endsection