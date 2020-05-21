@extends('layouts.backend')

@section('content')

<div class="uk-container uk-margin-bottom">
<div class="uk-card uk-card-default uk-card-body" uk-height-viewport="offset-top: true">

<h2 class="uk-card-header">{{ __('Shorts') }}</h2>

@include('partials.form_errors')
@include('partials.messages')

{{-- Records filter --}}
<form class="uk-margin-bottom" id="search-form" method="get" action="{{ route('admin.shorts.index') }}">
<div class="uk-inline uk-width-1-1@s uk-width-1-2@m">
<button type="submit" class="uk-form-icon uk-form-icon-flip uk-button-primary" uk-icon="icon: search"></button>
<input type="text" name="q" class="uk-input" placeholder="{{ __('Filter records') }}">
</div>
</form>

{{-- List controls --}}
<ul class="uk-iconnav uk-margin-bottom">
<li><a class="uk-text-primary" href="{{ route('admin.shorts.add') }}" uk-icon="icon: plus; ratio: 1.2" uk-tooltip="title: {{ __('Add new record') }}; pos: bottom-left"></a></li>
<li><button id="button-trash" type="button" class="uk-text-danger"  uk-icon="icon: trash; ratio: 1.2" uk-tooltip="title: {{ __('Delete all of selected') }}; pos: bottom-center"></button></li>
<li><button id="button-import" uk-toggle="target: #upload-modal"  type="button" class="uk-text-primary" uk-icon="icon: pull; ratio: 1.2" uk-tooltip="title: {{ __('Import from text/csv') }}; pos: bottom-center"></button></li>
<li><a class="uk-text-primary" href="{{ route('admin.shorts.help') }}" uk-icon="icon: question; ratio: 1.2" uk-tooltip="title: {{ __('User\'s manual') }}; pos: bottom-left" target="_blank"></a></li>
</ul>

{{-- List itself --}}
<div class="uk-overflow-auto">
<form id="selected-form" method="POST" action="{{ route('admin.shorts.delete') }}">
@csrf
@method('delete')
<table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-middle">
<thead>
<tr>
<th><input class="uk-checkbox" type="checkbox" id="select-all"></th>
<th>Id</th>
<th>{{ __('Tags') }}</th>
<th class="uk-width-1-4" style="word-break:break-all;">{{ __('URL') }}</th>
<th>{{ __('Short') }}</th>
<th>{{ __('Details') }}</th>
<th>{{ __('Active') }}</th>
<th>{{ __('Expires') }}</th>
</tr>	
</thead>
<tbody>
@foreach($shorts as $short)
<tr>
{{-- Check box --}}
<td><input type="checkbox" class="uk-checkbox" name="selected[]" value="{{ $short->id }}"></td>
{{-- Id --}}
<td class="uk-table-link"><a class="uk-link-reset" href="{{ route('admin.shorts.edit', ['id' => $short->id]) }}" uk-tooltip="title: {{ __('Click to edit') }}; pos: bottom-center">{{ $short->id }}</a></td>
{{-- Tags --}}
<td class="uk-table-link"><a class="uk-link-reset" href="{{ route('admin.shorts.edit', ['id' => $short->id]) }}" uk-tooltip="title: {{ __('Click to edit') }}; pos: bottom-center">{{ $short->tags }}</a></td>
{{-- URL --}}
<td class="uk-table-link uk-width-1-4"><a class="uk-link-reset" href="{{ route('admin.shorts.edit', ['id' => $short->id]) }}" uk-tooltip="title: {{ __('Click to edit') }}; pos: bottom-center">{{ Str::limit($short->url, 35) }}</a></td>
{{-- Short --}}
<td class="uk-table-link"><a class="uk-link-reset" href="{{ request()->getSchemeAndHttpHost()}}/{{ $short->identifier }}" target="_blank" uk-tooltip="title: {{ __('Click to test short URL') }}; pos: bottom-center">{{ request()->getSchemeAndHttpHost()}}/{{ $short->identifier }}</a></td>
{{-- View --}}
<td><a class="uk-icon-link" href="{{ route('admin.shorts.view', ['id' => $short->id]) }}" uk-tooltip="title: {{ __('Click to get Qr code') }}; pos: bottom-center" uk-icon="icon: download; ratio: 1.2"></a></td>
{{-- Active --}}
<td>
@if ($short->active)
<span uk-icon="icon: check"></span>
@else
<span uk-icon="icon: ban"></span>
@endif
</td>
{{-- Expires --}}
<td class="uk-table-expand"><small>{{ $short->expires }}</small></td>
</tr>
@endforeach

</tbody>
</table>
</form>

</div>

{{ $shorts->links('vendor.pagination.default') }}
</div>
</div>
@endsection

@section('modals')
@include('partials.upload_modal')
@endsection

@section('scripts')
<script>
$('#button-trash').on('click', function() {
	$('#selected-form').submit();
});

$('#select-all').on('click', function () {    
     $('#selected-form input:checkbox').not(':disabled').prop('checked', this.checked);    
 });
</script>
@endsection