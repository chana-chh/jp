@extends('sabloni.app')

@section('naziv', 'Ток новца')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца
    </h1>
{{-- Sekcija sa krugovima - POCETAK --}}
<div class="row">
<div class="col-md-10 col-md-offset-1 boxic">

<div class="row">
<div class="col-md-6">
<h3>Сума вредности спорова:</h3>
</div>
<div class="col-md-6">
<h3>Сума износа трошкова:</h3>
</div>
</div>
<hr class="ceo">
<div class="row">
<div class="col-md-3">
<h3>Град потражује:</h3>
<p class="tankoza krug">{{number_format($vrednost_spora_potrazuje_suma, 2)}}</p>
</div>
<div class="col-md-3">
<h3>Град дугује:</h3>
<p class="tankoza krug">{{number_format($vrednost_spora_duguje_suma, 2)}}</p>
</div>
<div class="col-md-3">
<h3>Град потражује:</h3>
<p class="tankoza krug">{{number_format($iznos_troskova_potrazuje_suma, 2)}}</p>
</div>
<div class="col-md-3">
<h3>Град дугује:</h3>
<p class="tankoza krug">{{number_format($iznos_troskova_duguje_suma, 2)}}</p>
</div>
</div>

</div>
</div>
{{-- Sekcija sa krugovima - KRAJ --}}

{{-- Sekcija sa dugicima - POCETAK --}}
<div class="row dugmici">
<div class="col-md-10 col-md-offset-1">

<div class="row">
<div class="col-md-6" style="border-right: 2px dashed #18BC9C" >
<h3>Табеларни приказ:</h3>
<div class="row">
<div class="col-md-6">
<button type="button" class="btn btn-primary btn-block">Груписано по предметима</button>
</div>
<div class="col-md-6">
<button type="button" class="btn btn-primary btn-block">Груписано по врсти предмета</button>
</div>
</div>
</div>
<div class="col-md-6">
<h3>Графички приказ:</h3>
<div class="row">
<div class="col-md-6">
<button type="button" class="btn btn-primary btn-block">Претходни месец</button>
</div>
<div class="col-md-6">
<button type="button" class="btn btn-primary btn-block">Претходних шест месеци</button>
</div>
</div>
</div>
</div>

</div>
</div>
{{-- Sekcija sa dugmicima - KRAJ --}}
@endsection