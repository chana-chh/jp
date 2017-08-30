@extends('sabloni.app')

@section('naziv', 'Почетна')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Почетна страна</h1>

    <div class="row" style="margin-top: 80px;">

        <div class="col-md-4">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h2 class="text-center">
                        <a href="{{ route('predmeti') }}" style="text-decoration: none; color: #2c3e50" >Предмети</a>
                    </h2>
                </div>
                <div class="panel-body">
                    <a href="{{ route('predmeti') }}">
                    <img class="grow center-block" alt="predmeti" src="{{url('/images/predmeti.png')}}" style="height:128px;">
                    </a>
                </div>
                <div class="panel-footer text-center">
                    <h3>
                        Укупно предмета:
                        <a href="{{ route('predmeti') }}"  style="text-decoration: none;">
                            <strong>{{ $broj_predmeta }}</strong>
                        </a>
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h2 class="text-center">
                        <a href="{{ route('rocista.kalendar') }}" style="text-decoration: none; color: #2c3e50">Календар</a>
                    </h2>
                </div>
                <div class="panel-body">
                    <a href="{{ route('rocista.kalendar') }}">
                        <img class="grow center-block" alt="kalendar" src="{{url('/images/kalendar.png')}}" style="height:128px;">
                    </a>
                </div>
                <div class="panel-footer text-center">
                    <h3>
                        Рочишта ове недеље:
                        <a href="{{ route('rocista.kalendar') }}"  style="text-decoration: none;">
                            <strong>{{ $rocista }}</strong>
                        </a>
                    </h3>
                </div>
            </div>
        </div>
{{--  <div class="col-md-4">
<div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h2 class="text-center">
                        <a href="{{ route('rocista') }}" style="text-decoration: none; color: #2c3e50">Рочишта</a>
                    </h2>
                </div>
                <div class="panel-body">
  <a href="{{ route('rocista') }}">
  <img class="grow center-block" alt="rokovi" src="{{url('/images/rokovi.png')}}" style="height:128px;">
  </a>
   </div>
                <div class="panel-footer text-center">
                    <h3>
                        А шта овде ???
                    </h3>
                </div>
            </div>
</div>  --}}

        <div class="col-md-4">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h2 class="text-center">
                        <a href="#" style="text-decoration: none; color: #2c3e50">Ток новца</a>
                    </h2>
                </div>
                <div class="panel-body">
                    <a href="#">
                        <img class="grow center-block" alt="novac" src="{{url('/images/novac.png')}}" style="height:128px;">
                    </a>
                </div>
                <div class="panel-footer text-center">
                  <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
</div>
@endsection

@section('skripte')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Септембар", "Октобар", "Новембар", "Децембар", "Јануар", "Фебруар"],
        datasets: [{
            label: 'Биланс',
            data: [120000, 19000, 73000, 50000, 42000, 83000],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
@endsection