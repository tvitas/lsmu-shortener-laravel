@extends('layouts.frontend')

@section('content')

<div class="uk-flex uk-flex-center uk-flex-middle" uk-height-viewport="offset-top: true">

<div class="uk-margin-left uk-margin-right uk-card uk-card-default uk-card-hover uk-card-body uk-width-1-2@m uk-width-1-3@l">

<h3 class="uk-card-title">{{ __('Login') }}</h3>
<form class="uk-form-stacked" role="form" method="POST" action="{{ route('login') }}">
@csrf
<div>
<input placeholder="{{ __('E – mail or AD user') }}" id="email" type="text" class="uk-input{{ $errors->has('email') ? ' uk-form-danger' : '' }}" name="email" value="{{ old('email') }}"autofocus>
</div>
<div class="uk-margin">
<input placeholder="{{ __('Password') }}" id="password" type="password" class="uk-input{{ $errors->has('password') ? ' uk-form-danger' : '' }}" name="password" value="{{ old('password') }}">
</div>
<div class="uk-margin">
<button class="uk-button uk-button-primary" type="submit" name="button">{{ __('Login') }}</button>
</div>
</form>
@include('partials.form_errors')
@include('partials.messages')

</div>
</div>
@endsection
