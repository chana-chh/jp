@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца у текућем месецу
    </h1>
    <div class="row" style="margin-top: 50px">
<div class="col-md-12 boxic">

    <canvas id="tekuci_mesec" height="450"></canvas>

        </div>
        </div>

        <div class="row" style="margin-top: 40px">
    <div class="col-md-10 col-md-offset-1">
    <a href="{{ route('tok') }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-circle-left"></i> Назад на ток предмета</a>
    </div>
    </div>
@endsection

@section('skripte')
<script src="{{ asset('/js/Chart.min.js') }}"></script>
<script>
$( document ).ready(function() {
var grafik = document.getElementById("tekuci_mesec");
var tekuci_mesec = new Chart(grafik, {
type: 'doughnut',
    data: {
      labels: ["Вредност спора потражује: {!! $vrednost_spora_potrazuje_mesec !!}", "Вредност спора дугује: {!! $vrednost_spora_duguje_mesec !!}","Износ трошкова потражује: {!! $iznos_troskova_potrazuje_mesec !!}","Износ трошкова дугује: {!! $iznos_troskova_duguje_mesec !!}"],
      datasets: [{
        label: "Неки наслов нисам баш сигуран који",
        backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9"],
        data: [{!! $vrednost_spora_potrazuje_mesec !!},{!! $vrednost_spora_duguje_mesec !!},{!! $iznos_troskova_potrazuje_mesec !!},{!! $iznos_troskova_duguje_mesec !!}]
      }]
    },
    options: {
      title: {
        display: true,
        fontColor: "#2C3E50",
        fontSize: 20,
        text: 'Неки додатни текст нисам сигуран који'
      },
      legend: {
      display: true,
      position: 'bottom',
      labels: {
        fontColor: "#2C3E50",
        fontSize: 20,
      }
    },
      maintainAspectRatio: false,
    }
});
});
</script>
@endsection