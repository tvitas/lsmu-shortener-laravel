<div class="uk-card uk-card-default uk-card-body uk-margin">

<h2 class="uk-card-header">{{ __('Shorts') }} {{ __('add') }}</h2>

<form class="uk-form">

<div class="uk-inline uk-margin-bottom uk-width-1-1">
<button type="button" id="url-generate" class="uk-form-icon uk-form-icon-flip uk-button-primary" uk-icon="icon: link"></button>
<input class="uk-input" type="text" id="url" value="https://forms.office.com/Pages/ResponsePage.aspx?id=uy1DDa_e9UKv3oLWh4_f_08iXptKVzpBmqyX7VXonPZUN1dRMkdOUDRDU1RaOE05OFNRNEdHSjBURS4u" placeholder="{{ __('URL to be shortened') }}">
</div>

<input class="uk-input" type="hidden" id="identifier">


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<p class="uk-text-danger">{{ __('Short URL') }}: <span id="genurl">{{ request()->getSchemeAndHttpHost()}}/oc5o1fyxeo</span></p>
</div>

<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-2@m">
<label>{{ __('Tags') }}</label>
<input class="uk-input">
</div>


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<input type="hidden" name="active" value="0">
<label><input class="uk-checkbox" type="checkbox" name="active" value="1"> {{ __('Active') }}</label>
</div>


<div class="uk-margin-bottom uk-width-1-1@s uk-width-1-3@m">
<label>{{ __('Short URL expires on') }}</label>
<input class="uk-input" type="text" name="expires" value="2024-12-31 00:00:00">
</div>

<div uk-accordion>
<div>
<a class="uk-accordion-title uk-width-1-1@s uk-width-1-2@m uk-width-1-3@l" href="#" style="font-size: 1rem">{{ __('Share with') }}</a>
<div class="uk-accordion-content">


<div class="uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>
<div>
<label><input class="uk-margin-right uk-checkbox" type="checkbox" name="shares[]">Vardenis Pavardenis</label>
</div>
</div>

</div>
</div>
</div>


<button class="uk-margin uk-button uk-button-primary" type="button">{{ __('Add') }}</button>
<button class="uk-margin uk-button uk-button-danger" type="button">{{ __('Cancel') }}</button>
</form>



</div>