<nav class="uk-navbar-container uk-background-primary uk-navbar-transparent uk-margin-bottom uk-box-shadow-medium uk-light" uk-navbar="mode: click">
<div class="uk-navbar-left">
<button class="uk-navbar-item uk-hidden@m" uk-icon="icon: menu; ratio: 1.5" uk-toggle="target: #offcanvas-bar"></button>
<a class="uk-navbar-item uk-logo uk-active" href="{{ url('/') }}">{{ __(config('app.name', 'Laravel')) }}</a>
</div>

<div class="uk-navbar-center uk-visible@m">
<ul class="uk-navbar-nav">
@auth
<li @if (request()->route()->getName() == 'admin.shorts.index') class="uk-active" @endif><a href="{{ route('admin.shorts.index') }}">{{ __('Shorts') }}</a></li>
@can('all', 'App\User')
<li @if (request()->route()->getName() == 'admin.users.index') class="uk-active" @endif><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
@endcan
@endauth
</ul>
</div>

<div class="uk-navbar-right uk-visible@m">
<ul class="uk-navbar-nav">
@auth
<li>
<a href="#">
	<span class="uk-margin-right" uk-icon="icon: user"></span>{{ Auth::user()->name }}
	<span class="uk-margin-left uk-margin-right" uk-icon="icon: users"></span>{{ __(Auth::user()->role) }}
</a>
</li>

<li>
<a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">{{ __('Logout') }}</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
@csrf
</form>
</li>
@endauth
@foreach (config('app.locales', []) as $locale)
<li><a href="#" onclick="event.preventDefault(); $('#lang').val('{{ $locale }}');$('#locale-form').submit()">{{ $locale }}</a></li>
@endforeach
<form id="locale-form" action="{{ route('setLang') }}" method="POST" style="display: none;">
@csrf
<input type="hidden" id="lang" name="lang">
</form>
</ul>
</div>
</nav>

@section('offcanvas')
<div id="offcanvas-bar" uk-offcanvas="overlay: true; mode: reveal">
<div class="uk-offcanvas-bar">
@include('partials.lang_switcher')
@include('partials.login_logout_offcanvas')
</div>
</div>
@endsection