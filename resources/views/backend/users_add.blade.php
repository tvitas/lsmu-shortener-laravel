@extends('layouts.backend')

@section('content')

<div class="uk-container uk-margin-bottom"  uk-height-viewport="offset-top: true">
<div class="uk-card uk-card-default uk-card-body">

<h2 class="uk-card-header">{{ __('User') }} {{ __('add') }}</h2>

@include('partials.form_errors')
@include('partials.messages')

<form class="uk-form" action="{{ route('admin.users.add.save') }}" method="POST">
@csrf

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-2@m">
<input class="uk-input" type="text" name="name" value="{{ request()->old('name') }}" placeholder="{{ __('Name') }}">
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-2@m">
<input class="uk-input" type="text" name="email" value="{{ request()->old('email') }}" placeholder="{{ __('E – mail or AD user') }}">
</div>

<div class="uk-margin-bottom  uk-width-1-1@s uk-width-1-2@m">
<ul uk-accordion>
<li class="uk-open">
<a class="uk-accordion-title" href="#" style="font-size: 1rem">{{ __('Password') }}</a>
<div class="uk-accordion-content">

<div class="uk-margin-bottom">
<input class="uk-input" type="password" name="password" placeholder="{{ __('New password') }}">
</div>

<div class="uk-margin-bottom">
<input class="uk-input" type="password" name="password_confirmation" placeholder="{{ __('Confirm new password') }}">
</div>

</div>
</li>
</ul>
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-2@m">
<label>{{ __('Role') }}</label>
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-2@m">
<select class="uk-select" name="role">
<option value="">{{ __('Please select') }}</option>
<option value="user" selected>{{ __('User') }}</option>
<option value="admin">{{ __('Administrator') }}</option>
<option value="root">{{ __('Root') }}</option>
</select>
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<input type="hidden" name="active" value="0">
<label><input class="uk-checkbox uk-margin-right" type="checkbox" name="active" value="1" checked>{{ __('Active') }}</label>
</div>


<button class="uk-button uk-button-primary" type="submit">{{ __('Save') }}</button>
<a class="uk-button uk-margin uk-button-danger" href="{{ route('admin.users.index') }}">{{ __('Cancel') }}</a>
</form>

</div>
</div>

@endsection
