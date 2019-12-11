<div uk-accordion>
<div>
<a class="uk-accordion-title uk-width-1-1@s uk-width-1-2@m uk-width-1-3@l" href="#" style="font-size: 1rem">{{ __('Share with') }}</a>
<div class="uk-accordion-content">


<div class="uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-6@l" uk-grid>
@php ($owner = '')
@foreach ($users as $user)
@if ($user->id == Auth::user()->id)
@php ($owner = ' checked disabled')
@endif
<div>
@php ($checked = '')
@foreach ($short->users as $shared)
@if ($shared->id == $user->id)
@php ($checked = ' checked')
@break
@endif
@endforeach
<label><input class="uk-margin-right uk-checkbox" type="checkbox" name="shares[]" value="{{ $user->id }}"{{ $checked }}{{ $owner }}>{{ $user->name }}</label>
@if ($owner)
<input type="hidden" name="shares[]" value="{{ $user->id }}">
@endif
</div>
@endforeach
</div>

</div>
</div>
</div>
