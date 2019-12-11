<div id="upload-modal" class="uk-flex-top" uk-modal>
<div class="uk-modal-dialog uk-margin-auto-vertical">
<button class="uk-modal-close-default" type="button" uk-close></button>

<div class="uk-modal-header">
<h2 class="uk-modal-title">{{ __('Import') }}</h2>
</div>

<div class="uk-modal-body">

<form  id="upload-form" method="post" enctype="multipart/form-data" action="{{route('admin.shorts.upload')}}">
@csrf
<div class="uk-margin-bottom">

<div uk-form-custom="target: true" class="uk-width-1-1">
<input type="file" name="files" accept="text/csv,text/plain,.txt,.csv">
<input class="uk-input uk-width-1-1" type="text" placeholder="{{ __('Select file') }}" disabled>
</div>

</div>
<p>{{ __('Plain text or CSV files only') }}</p>
<button id="upload-button" type="submit" class="uk-button uk-button-primary">{{ __('Import') }}</button>
</form>

</div>

</div>
</div>
