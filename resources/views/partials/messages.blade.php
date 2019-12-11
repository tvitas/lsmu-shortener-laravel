@foreach (['danger', 'warning', 'success', 'primary'] as $alertType)
@if(session()->has($alertType))
@foreach (collect(session()->get($alertType)) as $message)
<div class="uk-alert-{{ $alertType }}" uk-alert>
<a class="uk-alert-close" uk-close></a>
<div class="uk-margin-top">
{{ $message }}
</div>
</div>
@endforeach
@endif
@endforeach
