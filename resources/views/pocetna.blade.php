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
                    <h3 class="text-center">
                        <a href="{{ route('predmeti') }}" style="text-decoration: none; color: #2c3e50" >Предмети</a>
                    </h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('predmeti') }}">
                    <img class="grow center-block" alt="predmeti" src="{{url('/images/predmeti.png')}}" style="height:100px;">
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
                    <h3 class="text-center">
                        <a href="{{ route('izbor') }}" style="text-decoration: none; color: #2c3e50">Календар</a>
                    </h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('izbor') }}">
                        <img class="grow center-block" alt="kalendar" src="{{url('/images/kalendar.png')}}" style="height:100px;">
                    </a>
                </div>
                <div class="panel-footer text-center">
                    <h4>
                        Рочишта ове недеље:
                        <a href="{{ route('rocista.kalendar') }}"  style="text-decoration: none;">
                            <strong>{{ $rocista }}</strong>
                        </a>
                    </h4>
                    <h4>
                        Рокови ове недеље:
                        <a href="{{ route('rokovi.kalendar') }}"  style="text-decoration: none;">
                            <strong>{{ $rokovi }}</strong>
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h3 class="text-center">
                        <a href="{{ route('tok') }}" style="text-decoration: none; color: #2c3e50">Ток новца</a>
                    </h3>
                </div>
                <div class="panel-body">
                    <a href="{{ route('tok') }}">
                        <img class="grow center-block" alt="novac" src="{{url('/images/novac.png')}}" style="height:100px;">
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

{{--          <div class="col-md-3">

<div class="panel panel-info noborder">
                <div class="panel-heading">
                    <h3 class="text-center">
                        <a href="#" style="text-decoration: none; color: #2c3e50">Извештаји</a>
                    </h3>
                </div>
                <div class="panel-body">
  <a href="#">
  <img class="grow center-block" alt="rokovi" src="{{url('/images/stampac.png')}}" style="height:100px;">
  </a>
   </div>
                <div class="panel-footer text-center">
                    <h3>
                        Штампање извештаја
                    </h3>
                </div>
            </div>
</div> --}}
</div>
<hr>
<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#zamena" aria-controls="zamena" role="tab" data-toggle="tab">Замена референата</a></li>
    <li role="presentation"><a href="#danas" aria-controls="danas" role="tab" data-toggle="tab">Рочишта данас</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="zamena">
        <div class="row">
            <div class="col-md-10">
                <br>
                    <table class="table table-condensed table-striped" style="table-layout: fixed;">
                        <tbody>
                            @foreach($rocistatab as $r)
                                @if($r->zamena)
                                    <tr>
                                        <th style="width: 15%;"><strong>{{ date('d.m.Y', strtotime($r->datum)) }}</strong></th>
                                            <td style="width: 15%;" class="text-danger">{{date('H:i', strtotime($r->vreme))}}</td>
                                            <td style="width: 20%;">{{$r->predmet->referent->imePrezime()}}</td>
                                            <td style="width: 20%;"><i>ће бити замењен/a</i></td>
                                            <td style="width: 20%;">{{ $r->zamena->imePrezime() }}</td>
                                            <td style="width: 10%;"><a href="{{route('predmeti.pregled', $r->predmet->id)}}">{{$r->predmet->broj()}}</a></td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
            </div>
             @if (Gate::allows('admin'))
                <div class="col-md-2 text-right" style="margin-top: 80px;">
                    <a href="{{route('referenti.ciscenje')}}" class="btn btn-danger">
                        <i class="fa fa-trash"></i> Поништи све замене
                    </a>
                </div>
            @endif
    </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="danas">
        <ul style="margin-top: 20px; font-size: 1.2em">
            @foreach($danas as $d)
                <li>{{date('H:i', strtotime($d->vreme))}},
                    @if ($d->predmet->referentZamena)
                    {{$d->predmet->referentZamena->imePrezime()}}
                    @else
                    {{$d->predmet->referent->imePrezime()}}
                    @endif
                    <a href="{{route('predmeti.pregled', $d->predmet->id)}}">{{$d->predmet->broj()}}</a>
                </li>
            @endforeach
        </ul>
    </div>
  </div>

</div>

@endsection