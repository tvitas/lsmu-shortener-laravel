<ul class="uk-nav uk-nav-default">
@foreach (config('app.locales', []) as $locale)
<li @if (app()->getLocale() == $locale) class="uk-active" @endif><a href="#" onclick="event.preventDefault(); $('#lang').val('{{ $locale }}');$('#locale-form').submit()">{{ Str::title($locale) }}</a></li>
@endforeach
<li class="uk-nav-divider"></li>
</ul>
<form id="locale-form" action="{{ route('setLang') }}" method="POST" style="display: none;">
@csrf
<input type="hidden" id="lang" name="lang">
</form>