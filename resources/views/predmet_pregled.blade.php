@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
        Преглед предмета број
        <span class="{{ $predmet->arhiviran == 0 ? 'text-success' : 'text-danger' }}">
            {{ $predmet->vrstaUpisnika->slovo }} {{ $predmet->broj_predmeta }}/{{ $predmet->godina_predmeta }}
            {{ $predmet->arhiviran == 0 ? '' : ' - (а/а)' }}
        </span>
    </h1>
@endsection

@section('sadrzaj')
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Датум:</div>
        <div class="col-md-9">{{ date('d.m.Y', strtotime($predmet->datum_tuzbe)) }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Суд:</div>
        <div class="col-md-9">{{ $predmet->sud->naziv }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Врста предмета:</div>
        <div class="col-md-9">{{ $predmet->vrstaPredmeta->naziv }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Катастарска парцела:</div>
        <div class="col-md-9">{{ $predmet->opis_kp }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Адреса:</div>
        <div class="col-md-9">{{ $predmet->opis_adresa }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Опис предмета:</div>
        <div class="col-md-9">{{ $predmet->opis }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Странка 1:</div>
        <div class="col-md-9">{{ $predmet->stranka_1 }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Странка 2:</div>
        <div class="col-md-9">{{ $predmet->stranka_2 }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Вредност тужбе:</div>
        <div class="col-md-9">{{ $predmet->vrednost_tuzbe }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Референт:</div>
        <div class="col-md-9">{{ $predmet->referent->ime }} {{ $predmet->referent->prezime }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Предмет родитељ:</div>
        <div class="col-md-9">
        @if($predmet->roditelj)
            {{ $predmet->roditelj->vrstaUpisnika->slovo }}
            {{ $predmet->roditelj->broj_predmeta }}/{{ $predmet->roditelj->godina_predmeta }}
        @endif
        </div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Напомена:</div>
        <div class="col-md-9">{{ $predmet->napomena }}</div>
    </div>
@endsection

@section('traka')
<div class="well">
    <h3>Рочишта</h3>
    @foreach ($predmet->rocista as $rociste)
        <p>
            {{ $rociste->tipRocista->naziv }} дана {{ date('d.m.Y', strtotime($rociste->datum)) }} у {{ date('H:i', strtotime($rociste->vreme)) }} часова. {{ $rociste->opis }}
        </p>
    @endforeach
</div>
<div class="well">
    <h3>Токови</h3>
    @foreach ($predmet->tokovi as $tok)
        {{ date('d.m.Y', strtotime($tok->datum)) }} -
        {{ $tok->status->naziv }} ({{ $tok->opis }})<br>
        Вредност спора потражује: {{ $tok->vrednost_spora_potrazuje }}<br>
        Вредност спора дугује: {{ $tok->vrednost_spora_duguje }}<br>
        Износ трошкова потражује: {{ $tok->iznos_troskova_potrazuje }}<br>
        Износ трошкова дугује: {{ $tok->iznos_troskova_duguje }}<br>
    @endforeach
</div>
<div class="well">
    <h3>Управе</h3>
    @foreach ($predmet->uprave as $uprava)
    <p>
        {{ $uprava->sifra }} - {{ $uprava->naziv }}
        {{ $uprava->napomena }}
    </p>
    @endforeach
</div>
@endsection

{{--  @section('skripte')
<script>
$( document ).ready(function() {
    $('#tabelaPredmeti').DataTable({
        language: {
            search: "Пронађи у табели",
            paginate: {
                first:      "Прва",
                previous:   "Претходна",
                next:       "Следећа",
                last:       "Последња"
            },
            processing:   "Процесирање у току...",
            lengthMenu:   "Прикажи _MENU_ елемената",
            zeroRecords:  "Није пронађен ниједан запис",
            info:         "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
            infoFiltered: "(filtrirano од укупно _MAX_ елемената)",
            responsive: true
        }
    });
});
</script>
@endsection  --}}