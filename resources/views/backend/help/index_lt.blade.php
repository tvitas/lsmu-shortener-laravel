@extends('layouts.clean-html')

@section('content')
<div class="uk-container uk-margin" style="background: #fff;">

<h2 id="start">{{ __('User\'s manual') }}</h2>
<h3 id="index">Turinys</h3>
<ul class="uk-list">
<li><a href="#login-to-system">Prisijungti prie sistemos</a></li>
<li><a href="#url-list">URL sąrašas</a></li>
<li><a href="#add-record">Įvesti URL</a>
<ul class="uk-list"><li><a href="#import-url-list">Importuoti URL sąrašą</a></li></ul>
</li>
<li><a href="#get-qr-code">Gauti QR kodą</a>
<ul class="uk-list"><li><a href="#qr-archive">QR kodo failų archyvas</a></li></ul>
</li>
<li><a href="#edit-record">Taisyti URL įrašą</a></li>
<li><a href="#delete-record">Ištrinti URL įrašą</a></li>
</ul>
<p>link.lsmu.lt – sistema kurios pagalba galima sutrumpinti ilgus URL ir sugeneruoti URL QR kodą.</p>
<p>
Sistemos naudotojas gali įvesti ilgą URL ir gauti jo sutrumpinimą, kuris bus tokios struktūros: <strong>https://link.lsmu.lt/[atsitiktinių 10 simbolių eilutė]</strong>, taip pat nustatyti trumpo URL galiojimo laikotarpį, bei sugeneruoti ilgojo URL ir trumpinio QR kodą. 
Įvesti įrašai saugomi duomenų bazės lentelėse ir gali būti modifikuojami, naikinami. 
</p>
<h3 id="login-to-system">Prisijungti prie sistemos</h3>
<ol>
<li>Naršyklės adreso laukelyje surinkti https://link.lsmuni.lt. Atverčiamas prisijungimo prie sistemos puslapis.</li>
<li>Į laukelį „El. paštas, arba AD naudotojo vardas“ įvesti LSMU naudotojo vardą</li>
<li>Į laukelį „Spatažodis“ įvesti LSMU naudotojo slaptažodį</li>
<li>Spausti „Prisijungti“, arba ENTER. Jeigu naudotojo vardas ir slaptažodis teisingai įvesti, atverčiamas URL, kuriuos įvedė naudotojas, sąrašas.</li>
</ol>
<h3 id="url-list">URL sąrašas</h3>
<p>Sąraše atvaizduojami naudotojo įvesti URL, šių URL trumpiniai ir pateikiami valdymo elementai, kurių pagalba galima manipuliuoti URL sąrašo įrašais.</p>
{{-- List shot --}}
{{-- Records filter --}}
<div class="uk-inline uk-width-1-1@s uk-width-1-2@m uk-margin-bottom">
<button type="button" class="uk-form-icon uk-form-icon-flip uk-button-primary" uk-icon="icon: search"></button>
<input type="text" name="q" class="uk-input" placeholder="{{ __('Filter records') }}">
</div>
{{-- List controls --}}
<ul class="uk-iconnav uk-margin-bottom">
<li><a class="uk-text-primary" href="#" uk-icon="icon: plus; ratio: 1.2" uk-tooltip="title: {{ __('Add new record') }}; pos: bottom-left"></a></li>
<li><button id="button-trash" type="button" class="uk-text-danger"  uk-icon="icon: trash; ratio: 1.2" uk-tooltip="title: {{ __('Delete all of selected') }}; pos: bottom-center"></button></li>
<li><button id="button-import" type="button" class="uk-text-primary" uk-icon="icon: pull; ratio: 1.2" uk-tooltip="title: {{ __('Import from text/csv') }}; pos: bottom-center"></button></li>
<li><a class="uk-text-primary" href="#" uk-icon="icon: question; ratio: 1.2" uk-tooltip="title: {{ __('User\'s manual') }}; pos: bottom-left"></a></li>
</ul>

<div class="uk-overflow-auto">
<table class="uk-table uk-table-divider uk-table-striped uk-table-hover uk-table-middle">
<thead>
<tr>
<th><input class="uk-checkbox" type="checkbox" id="select-all"></th>
<th>{{ __('Tags') }}</th>
<th class="uk-width-1-4" style="word-break:break-all;">{{ __('URL') }}</th>
<th>{{ __('Short') }}</th>
<th>{{ __('Details') }}</th>
<th>{{ __('Active') }}</th>
<th>{{ __('Expires') }}</th>
</tr>	
</thead>
<tbody>
<tr>
{{-- Check box --}}
<td><input type="checkbox" class="uk-checkbox" name="selected[]"></td>
{{-- Tags --}}
<td class="uk-table-link"><a class="uk-link-reset" href="#" uk-tooltip="title: {{ __('Click to edit') }}; pos: bottom-center">Office365 apklausa</a></td>
{{-- URL --}}
<td class="uk-table-link uk-width-1-4"><a class="uk-link-reset" href="#" uk-tooltip="title: {{ __('Click to edit') }}; pos: bottom-center">{{ Str::limit('https://forms.office.com/Pages/ResponsePage.aspx?id=uy1DDa_e9UKv3oLWh4_f_08iXptKVzpBmqyX7VXonPZUN1dRMkdOUDRDU1RaOE05OFNRNEdHSjBURS4u', 35) }}</a></td>
{{-- Short --}}
<td class="uk-table-link"><a class="uk-link-reset" href="#" uk-tooltip="title: {{ __('Click to test short URL') }}; pos: bottom-center">{{ request()->getSchemeAndHttpHost()}}/oc5o1fyxeo</a></td>
{{-- View --}}
<td><a class="uk-icon-link" href="#" uk-tooltip="title: {{ __('Click to get Qr code') }}; pos: bottom-center" uk-icon="icon: download; ratio: 1.2"></a></td>
{{-- Active --}}
<td>
<span uk-icon="icon: check"></span>
<span uk-icon="icon: ban"></span>
</td>
{{-- Expires --}}
<td class="uk-table-expand"><small>2024-12-06 10:29:04</small></td>
</tr>
</tbody>
</table>
</div>
<ul class="uk-list">
<li><input type="text" class="uk-input uk-width-1-4@m" placeholder="{{ __('Filter records') }}"> – filtruoti įrašus. Įvesti frazę, arba frazės dalį, pagal kurią reikia filtruoti įrašus, spausti <button type="button" class="uk-button uk-button-primary" uk-icon="icon: search"></button></li>
<li><a class="uk-text-primary" href="#" uk-icon="icon: plus; ratio: 1.2" uk-tooltip="title: {{ __('Add new record') }}; pos: bottom-left"></a> – <a href="#add-record">įterpti</a> URL įrašą.</li>
<li><button id="button-trash" type="button" class="uk-text-danger"  uk-icon="icon: trash; ratio: 1.2" uk-tooltip="title: {{ __('Delete all of selected') }}; pos: bottom-center"></button> – <a href="#delete-record">ištrinti</a> pažymėtus URL įrašus.</li>
<li><button id="button-import" type="button" class="uk-text-primary" uk-icon="icon: pull; ratio: 1.2" uk-tooltip="title: {{ __('Import from text/csv') }}; pos: bottom-center"></button> – <a href="#import-url-list">importuoti</a> URL įrašus iš *.csv failo.</li>
<li><a class="uk-text-primary" href="#" uk-icon="icon: question; ratio: 1.2" uk-tooltip="title: {{ __('User\'s manual') }}; pos: bottom-left"></a> – atversti šį aprašymą.</li>
<li><a class="uk-icon-link" href="#" uk-tooltip="title: {{ __('Click to get Qr code') }}; pos: bottom-center" uk-icon="icon: download; ratio: 1.2"></a> – <a href="#get-qr-code">gauti</a> QR kodą.</li>
<li><span uk-icon="icon: check"></span> – jeigu įrašas galiojantis.</li>
<li><span uk-icon="icon: ban"></span> – jeigu įrašas negaliojantis.</li>
<li>Spausti eilutę, kurią reikia taisyti, ties stulpeliu „Žymė“, arba „URL“, jeigu reikia <a href="#edit-record">taisyti</a> įrašą.</li>
<li>Spausti trumpinio URL stulpelyje „Trumpinys“ jeigu reikia išbandyti trumpinį.</li>
</ul>

<h3 id="add-record">Įvesti naują URL įrašą</h3>
<ol>
<li>Spausti <a class="uk-text-primary" href="#" uk-icon="icon: plus; ratio: 1.2" uk-tooltip="title: {{ __('Add new record') }}; pos: bottom-left"></a> įrankių juostoje. Atverčiama naujo įrašo įvedimo forma.</li>
@include('backend.help.partials.help_add_form')
<li>Į laukelį „URL, kuris trumpinamas“ įvesti ilgąjį URL. Spausti <button type="button" class="uk-button uk-button-primary" uk-icon="icon: link"></button>. Sugeneruojamas ilgojo URL trumpinys.</li>
<li>Į laukelį „Žymės“ įvesti trumpinio pavadinimą. Pvz. „Office 365 apklausa“, arba „Basalis olive“.</li>
<li>Jeigu trumpinys galiojantis, t. y. tai ne koks „juodraštis“, pažymėti <label><input class="uk-checkbox" type="checkbox" value="1" checked> {{ __('Active') }}</label>.</li>
<li>Į laukelį „Trumpinys galioja iki“ įvesti trumpinio galiojimo pabaigos datą. Numatytoji reikšmė – 5 metai nuo trumpinio įvedimo datos/laiko.</li>
<li>Laukelyje „Dalintis“ galima pažymėti sistemos naudotojus, kurie taip pat matys šį trumpinio įrašą. Numatytoji reikšmė – trumpinio įrašą mato ir tvarko tik trumpinį įvedęs naudotojas, bei sistemos administratorius.</li>
<li>Spausti <button class="uk-button uk-button-primary" type="button">{{ __('Add') }}</button>. Įterpiamas naujas trumpinio įrašas. Grįžtama į trumpinių sąrašą.</li>
<li>Jeigu įrašo įterpti nereikia, spausti <button class="uk-button uk-button-danger" type="button">{{ __('Cancel') }}</button>. Grįžtama į trumpinių sąrašą</li>
</ol>
<h4 id="import-url-list">Importuoti URL sąrašą</h4>
<p>Galima iš anksto paruošti *.csv formato URL sąrašo failą ir jį importuoti į sistemą – nereikės kiekvieno URL įvedinėti atskirai.</p>
<ol>
<li>Paruošti URL sąrašo failą.
<ol>
<li>Failo tipas – tekstas.</li>
<li>Kiekvienas URL, kurį reikia sutrumpinti/generuoti QR kodą, įvedamas atskira eilute.</li>
<li>Toje pačioje eilutėje, kaip ir URL, atskirtas kableliu, gali būti ir URL žymės aprašymas.</li>
</ol>
</li>
<li>Spausti <button type="button" class="uk-text-primary" uk-icon="icon: pull; ratio: 1.2" uk-tooltip="title: {{ __('Import from text/csv') }}; pos: bottom-center"></button> įrankių juostoje. Atverčiama failo importui išrinkimo forma.
@include('backend.help.partials.help_upload_modal')
</li>
<li>Spausti „Pasirinkite failą importavimui“. Atverčiamas failo išrinkimo dialogas.</li>
<li>Išrinkti paruoštą failą su URL.</li>
<li>Spausti <button type="button" class="uk-button uk-button-primary">{{ __('Import') }}</button> URL iš paruošto failo importuojami į duomenų bazę, sugeneruojami URL trumpiniai.</li>
<li>Jeigu failo importuoti nereikia – spausti „&times;“ formos viršuje, dešinėje.</li>
</ol>
<h3 id="get-qr-code">Gauti QR kodą</h3>
<ol>
<li>Spausti <a class="uk-icon-link" href="#" uk-tooltip="title: {{ __('Click to get Qr code') }}; pos: bottom-center" uk-icon="icon: download; ratio: 1.2"></a> URL sąraše. Atverčiama įrašo peržiūros/QR kodo atsisiuntimo forma.
<div class="uk-text-center">
<img src="{{ asset('images/img-short-view.png') }}">	
</div>
</li>
<li>Su „potenciometru“ <input id="size_in" type="range" name="size" value="150" min="100" max="600" step="50"> galima pasirinkti atsisiunčiamojo QR kodo paveikslėlio dydį. Numatytoji reikšmė – 150 &times; 150 pikselių</li>
<li>Laukeliuose „Formatas“ galima pažymėti kokio formato paveikslėlis bus atsisiunčiamas. Numatytoji reikšmė – SVG, PNG, EPS.</li>
<li>Laukelyje „Failo vardo priešdėlis“ galima įvesti QR kodo failo vardo priešdėlį, pvz. „basalis-olive“. Numatytoji reikšmė – trumpojo URL identifikatorius.</li>
<li>Spausti <button type="button" class="uk-button uk-button-secondary">{{ __('Download') }}</button>. Sugeneruojami nurodyto dydžio originalaus URL ir trumpinio QR kodų archyvas, kurį galima išsaugoti kompiuterio atmintinėje. Archyvo failo vardas – <strong>archive.zip</strong></li>
<li>Spausti <button type="button" class="uk-button uk-button-primary">{{ __('Back') }}</button>. Grįžtama į URL sarašą.
</ol>
<h4 id="qr-archive">QR kodo failų archyvas</h4>
<p class="uk-text-center"><img src="{{ asset('images/img-archive-zip.png') }}"></p>
<h5>Atsisiųstame QR kodo paveikslėlių archyve failų vardų <strong>(pvz. 0-mo7a52n22m-300.svg)</strong> struktūra</h5>
<ul>
<li>Failo indeksas <strong>(0)</strong></li>
<li>URL įrašo peržiūros/QR kodo atsisiuntimo formoje įvestas failo vardo priešdėlis <strong>(mo7a52n22m)</strong>.
<li>Paveislėlio dydis pikseliais <strong>(300)</strong></li>
<li>Paveislėlio tipas <strong>(svg)</strong></li>
<li>Failai su indeksais <strong>0, 2, 4 – URL trumpinio QR kodas</strong></li>
<li>Failai su indeksais <strong>1, 3, 5 – ilgojo URL QR kodas</strong></li>
</ul>
<p class="uk-text-primary">Jeigu QR kodas bus naudojamas pvz. etiketės, ar plakato maketui ir jį reikės didinti/mažinti, reiktų naudoti vektorinius paveikslėlių tipus – SVG („scalable vector graphic“), arba EPS („encapsulated postscript“). 
Juos galima didinti/mažinti, neprarandant kokybės. 
Jeigu QR kodą reikia įdėti pvz. į tinklalapį, ar pristatymo skaidrę – užtenka PNG.</p>
<h3 id="edit-record">Taisyti URL įrašą</h3>
<ol>
<li>Spausti eilutę, kurią reikia taisyti, ties stulpeliu „Žymė“, arba „URL“. Atverčiama įrašo taisymo forma.</li>
<li>Taisymo veiksmai tokie patys, kaip ir <a href="#add-record">įvedant naują įrašą</a></li>
<li>Spausti <button class="uk-button uk-button-primary" type="button">{{ __('Save') }}</button>. Pakeitimai įrašomi, grįžtama į URL sąrašą.</li>
<li>Jeigu pakeitimų saugoti nereikia, spausti <button class="uk-button uk-button-danger" type="button">{{ __('Cancel') }}</button></li>
</ol>
<h3 id="delete-record">Ištrinti URL įrašą (-us)</h3>
<ol>
<li>Pažymėti <input type="checkbox" class="uk-checkbox" checked> eilutės kairėje įrašą (-us), kurį (-iuos) reikia ištrinti.</li>
<li>Spausti <button type="button" class="uk-text-danger" uk-icon="icon: trash; ratio: 1.2" uk-tooltip="title: {{ __('Delete all of selected') }}; pos: bottom-center"></button> įrankių juostoje.</li>
<li>Įrašai ištrinami. <span class="uk-text-danger">Šis veiksmas negrįžtamas.</span></li>
</ol>
</div>
@endsection