@extends('sabloni.app')

@section('naziv', 'Почетна')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Почетна страна</h1>

    <div class="row" style="margin: 20px; padding: 10px">

        <div class="col-md-3">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h3 class="text-center">
                        <a href="{{ route('predmeti') }}" style="text-decoration: none; color: #2c3e50" >Предмети</a>
                    </h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('predmeti') }}">
                    <img class="grow center-block" alt="predmeti" src="{{url('/images/predmeti.png')}}" style="height:128px;">
                    </a>
                </div>
                <div class="panel-footer text-center">
                    <h4>
                        Укупно предмета:
                        <a href="{{ route('predmeti') }}"  style="text-decoration: none;">
                            <strong>{{ $broj_predmeta }}</strong>
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h3 class="text-center">
                        <a href="{{ route('rocista.kalendar') }}" style="text-decoration: none; color: #2c3e50">Календар</a>
                    </h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('rocista.kalendar') }}">
                        <img class="grow center-block" alt="kalendar" src="{{url('/images/kalendar.png')}}" style="height:128px;">
                    </a>
                </div>
                <div class="panel-footer text-center">
                    <h4>
                        Рочишта ове недеље:
                        <a href="{{ route('rocista.kalendar') }}"  style="text-decoration: none;">
                            <strong>{{ $rocista }}</strong>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
<div class="col-md-3">
<div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h3 class="text-center">
                        <a href="{{ route('rocista') }}" style="text-decoration: none; color: #2c3e50">Рочишта</a>
                    </h3>
                </div>
                <div class="panel-body">
  <a href="{{ route('rocista') }}">
  <img class="grow center-block" alt="rokovi" src="{{url('/images/rokovi.png')}}" style="height:128px;">
  </a>
   </div>
                <div class="panel-footer text-center">
                    <h4>
                        А шта овде ???
                    </h4>
                </div>
            </div>
</div>

<div class="col-md-3">
<div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h3 class="text-center">
                        <a href="#" style="text-decoration: none; color: #2c3e50">Ток новца</a>
                    </h3>
                </div>
                <div class="panel-body">
  <a href="#">
  <img class="grow center-block" alt="novac" src="{{url('/images/novac.png')}}" style="height:128px;">
  </a>
   </div>
                <div class="panel-footer text-center">
                    <h4>
                        А шта овде ???
                    </h4>
                </div>
            </div>
</div>
</div>
@endsection