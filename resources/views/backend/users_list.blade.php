@extends('layouts.backend')

@section('content')

<div class="uk-container uk-margin-bottom">
<div class="uk-card uk-card-default uk-card-body" uk-height-viewport="offset-top: true">

<h2 class="uk-card-header">{{ __('Users') }}</h2>

@include('partials.form_errors')
@include('partials.messages')

{{-- Records filter --}}
<form class="uk-margin-bottom" id="search-form" method="get" action="{{ route('admin.users.index') }}">
<div class="uk-inline uk-width-1-1@s uk-width-1-2@m">
<button type="submit" class="uk-form-icon uk-form-icon-flip uk-button-primary" uk-icon="icon: search"></button>
<input type="text" name="qu" class="uk-input" placeholder="{{ __('Filter records') }}">
</div>
</form>

{{-- List controls --}}
<ul class="uk-iconnav uk-margin-bottom">
<li><a class="uk-text-primary" href="{{ route('admin.users.add') }}" uk-icon="icon: plus; ratio: 1.2" uk-tooltip="title: {{ __('Add new record') }}; pos: bottom-left"></a></li>
<li><button id="button-trash" type="button" class="uk-text-danger"  uk-icon="icon: trash; ratio: 1.2" uk-tooltip="title: {{ __('Delete all of selected') }}; pos: bottom-center"></button></li>
</ul>

{{-- List itself --}}
<div class="uk-overflow-auto">
<form id="selected-form" method="POST" action="{{ route('admin.users.delete') }}">
@csrf
@method('delete')
<table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-justify uk-table-middle">
<thead>
<tr>
<th><input class="uk-checkbox" type="checkbox" id="select-all"></th>
<th>{{ __('Name') }}</th>
<th>{{ __('Email/Login') }}</th>
<th>{{ __('Role') }}</th>
<th>{{ __('Active') }}</th>
<th>{{ __('Updated') }}</th>
</tr>	
</thead>
<tbody>
@foreach($users as $user)
<tr>
{{-- Check box --}}
<td><input type="checkbox" class="uk-checkbox" name="selected[]" value="{{ $user->id }}"></td>
{{-- Name --}}
<td class="uk-table-link"><a class="uk-link-reset" href="{{ route('admin.users.edit', ['id' => $user->id]) }}" uk-tooltip="title: {{ __('Click to edit user') }}; pos: bottom-center">{{ $user->name }}</a></td>
{{-- Email/Login --}}
<td class="uk-table-shrink uk-table-link"><a class="uk-link-reset" href="{{ route('admin.users.edit', ['id' => $user->id]) }}" uk-tooltip="title: {{ __('Click to edit user') }}; pos: bottom-center">{{ $user->email }}</a></td>
{{-- Role --}}
<td class="uk-table-link"><a class="uk-link-reset" href="{{ route('admin.users.edit', ['id' => $user->id]) }}" target="_blank" uk-tooltip="title: {{ __('Click to edit user') }}; pos: bottom-center">{{ $user->role }}</a></td>
{{-- Active --}}
<td>
@if ($user->active)
<span uk-icon="icon: check"></span>
@else
<span uk-icon="icon: ban"></span>
@endif
</td>
{{-- Updated --}}
<td>{{ $user->updated_at }}</td>
</tr>
@endforeach

</tbody>
</table>
</form>

</div>

{{ $users->links('vendor.pagination.default') }}
</div>
</div>
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