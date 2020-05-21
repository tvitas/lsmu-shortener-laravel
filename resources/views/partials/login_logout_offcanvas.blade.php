<ul class="uk-nav uk-nav-default">
@guest
<li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
@else
<li><span class="uk-margin-right" uk-icon="icon: user"></span>{{ Auth::user()->name }}</li>
<li><span class="uk-margin-right" uk-icon="icon: users"></span>{{ __(Auth::user()->role) }}</li>
<li class="uk-nav-divider"></li>
<li @if (request()->route()->getName() == 'admin.shorts.index') class="uk-active" @endif><a href="{{ route('admin.shorts.index') }}">{{ __('Shorts') }}</a></li>
@can('all', 'App\User')
<li @if (request()->route()->getName() == 'admin.users.index') class="uk-active" @endif><a href="{{ route('admin.users.index') }}">{{ __('Users') }}</a></li>
@endcan
<li class="uk-nav-divider"></li>
<li>
<a href="{{ route('logout') }}" onclick="event.preventDefault(); $('#logout-form').submit();">{{ __('Logout') }}</a>
</li>
@endguest
</ul>