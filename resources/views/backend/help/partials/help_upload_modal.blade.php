<div class="uk-card uk-card-default uk-card-body uk-margin uk-width-1-2@m">
<span class="uk-modal-close-default" type="button">&times;</span>

<div class="uk-modal-header">
<h2 class="uk-modal-title">{{ __('Import') }}</h2>
</div>

<div class="uk-modal-body">

<div class="uk-margin-bottom">

<div uk-form-custom="target: true" class="uk-width-1-1">
<input type="file" accept="text/csv,text/plain,.txt,.csv">
<input class="uk-input uk-width-1-1" type="text" placeholder="{{ __('Select file') }}" disabled>
</div>

</div>
<p>{{ __('Plain text or CSV files only') }}</p>
<button id="upload-button" type="button" class="uk-button uk-button-primary">{{ __('Import') }}</button>
</div>

</div>
