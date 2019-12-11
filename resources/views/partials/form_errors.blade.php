@if ($errors->any())
<div class="uk-alert-warning" uk-alert>
<a class="uk-alert-close" uk-close></a>
<div class="uk-margin-top">
<ul class="uk-list">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
</div>
@endif