@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
         Ток новца у текућој години
    </h1>
    <div class="row" style="margin-top: 50px">
    <div class="col-md-10 col-md-offset-1">
    <div class="row">
    <div class="col-md-12">
    <canvas id="tekuca_godina" height="450"></canvas>
    </div>
    </div>
    <div class="row">
    <div class="col-md-12" style="margin-top: 20px">
    <a href="{{ route('tok') }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-circle-left"></i> Назад на ток предмета</a>
    </div>
    </div>
        </div>
        </div>
@endsection

@section('skripte')
<script src="{{ asset('/js/Chart.min.js') }}"></script>
<script>
$( document ).ready(function() {

    var labelej =  {!!json_encode($labele)!!};
    var vrednosti_vspj =  {!!json_encode($vrednosti_vsp)!!};
    var vrednosti_vsdj =  {!!json_encode($vrednosti_vsd)!!};
    var vrednosti_itpj =  {!!json_encode($vrednosti_itp)!!};
    var vrednosti_itdj =  {!!json_encode($vrednosti_itd)!!};

    var grafik = document.getElementById("tekuca_godina");
var tekuca_godina = new Chart(grafik, {
    type: 'line',
  data: {
    labels: labelej,
    datasets: [{ 
        data: vrednosti_vspj,
        label: "Град потражује",
        borderColor: "#3e95cd",
        fill: false
      }, { 
        data: vrednosti_vsdj,
        label: "Град дугује",
        borderColor: "#8e5ea2",
        fill: false
      }, { 
        data: vrednosti_itpj,
        label: "Износ трошкова потражује",
        borderColor: "#3cba9f",
        fill: false
      }, { 
        data: vrednosti_itdj,
        label: "Износ трошкова дугује",
        borderColor: "#e8c3b9",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: false,
    },
    maintainAspectRatio: false,
  }
});
});
</script>
@endsection