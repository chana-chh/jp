@extends('sabloni.app')

@section('naziv', 'Почетна')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Почетна страна</h1>

    <div class="row" style="margin-top: 80px;">

        <div class="col-md-3">
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

        <div class="col-md-3">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h2 class="text-center">
                        <a href="{{ route('rocista.kalendar') }}" style="text-decoration: none; color: #2c3e50">Календар рочишта</a>
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

        <div class="col-md-3">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h2 class="text-center">
                        <a href="{{ route('tok') }}" style="text-decoration: none; color: #2c3e50">Ток новца</a>
                    </h2>
                </div>
                <div class="panel-body">
                    <a href="{{ route('tok') }}">
                        <img class="grow center-block" alt="novac" src="{{url('/images/novac.png')}}" style="height:128px;">
                    </a>
                </div>
                <div class="panel-footer text-center">
                <h5>
                    Салдо вредности спора:
                    <a href="#"  style="text-decoration: none;">
                        <strong class="{{ $vrednost_spora>= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($vrednost_spora, 2, ',', '.') }}
                        </strong>
                    </a>
                </h5>
                <h5>
                    Салдо износа трошкова:
                    <a href="#"  style="text-decoration: none;">
                        <strong class="{{ $iznos_troskova>= 0 ? 'text-success' : 'text-danger' }}">
                            {{ number_format($iznos_troskova, 2, ',', '.') }}
                        </strong>
                    </a>
                </h5>
                </div>
            </div>
        </div>

         <div class="col-md-3">
<div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h2 class="text-center">
                        <a href="#" style="text-decoration: none; color: #2c3e50">Извештаји</a>
                    </h2>
                </div>
                <div class="panel-body">
  <a href="#">
  <img class="grow center-block" alt="rokovi" src="{{url('/images/stampac.png')}}" style="height:128px;">
  </a>
   </div>
                <div class="panel-footer text-center">
                    <h3>
                        Штампање извештаја
                    </h3>
                </div>
            </div>
</div>
</div>
@endsection