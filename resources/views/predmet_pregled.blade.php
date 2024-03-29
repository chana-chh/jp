@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
@if($predmet->tokovi()->count() > 0)
@if($predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 8 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 18 || $predmet->tokovi()->orderBy('datum', 'desc')->first()->status_id == 28)
<div id="overlay" style="background-color: rgba(0, 0, 0, 0.2); z-index: 999; position: absolute; left: 0; top: 0; width: 100%; height: 100%"></div>
@endif
@endif
<div class="row">
    <div class="col-md-12">
        <h1>
            <img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:50px;">
            Преглед предмета број
            <span class="{{ $predmet->arhiviran == 0 ? 'text-success' : 'text-danger' }}">
                {{ $predmet->broj() }}
                &emsp;<span style="font-size: 2.5rem;">{{ $predmet->status() }} {{ $predmet->opis() }}</span>
            </span>
        </h1>
    </div>
</div>
<hr>
    @if($dete)
    <div class="row">
    <div class="col-md-6 text-center">
        <h5>Постоји веза са предметом <i class="fa fa-arrow-circle-down" aria-hidden="true"></i></h5>
</div>
</div>
<div>
<div class="col-md-6 text-center">
        <h5><a href="{{ route('predmeti.pregled', $dete->id) }}">{{$dete->broj()}}</a> </h5>
</div>
</div>
@endif
@endsection

@section('sadrzaj')
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2" style="z-index: 1000">
                <a href="{{ route('predmeti') }}" class="btn btn-primary btn-block ono" style="margin-top: 5px">
                    <i class="fa fa-arrow-circle-left"></i> На предмете
                </a>
            </div>
            <div class="col-md-2">
                <a href="{{ route('predmeti.izmena.get', $predmet->id) }}" class="btn btn-success btn-block ono" style="margin-top: 5px">
                    <i class="fa fa-pencil"></i> Измени
                </a>
            </div>
            @if (Auth::user()->level == 100 || Auth::user()->level == 0)
            <div class="col-md-3" style="z-index: 1000">
            @else
            <div class="col-md-3">
            @endif
                <button class="btn btn-warning btn-block ono" id="dugmeArhiviranje" style="margin-top: 5px">
                    <i class="fa fa-archive"></i> Архивирање/активирање
                </button>
            </div>
            <div class="col-md-3">
                <a href="{{ route('stampa', $predmet->id) }}" class="btn btn-success btn-block ono" style="margin-top: 5px">
                    <i class="fa fa-print"></i> Штампај уписник
                </a>
            </div>
            @if (Gate::allows('admin'))
            <div class="col-md-2">
                <button class="btn btn-danger btn-block ono" id="dugmeBrisanjePredmeta" style="margin-top: 5px">
                    <i class="fa fa-trash"></i> Брисање
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

{{--pocetak modal_predmet_brisanje--}}
<div class="modal fade" id="brisanjePredmetaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-danger">Брисање предмета</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите трајно да обришете овај предмет?</h3>
                <p class="text-danger">Ова акција је неповратна!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="dugmeModalObrisiPredmetBrisi">
                    <i class="fa fa-trash"></i> Обриши
                </button>
                <button type="button" class="btn btn-danger" id="dugmeModalObrisiPredmetOtkazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--kraj modal_predmet_brisanje--}}

{{--  pocetak modal_arhiviranje  --}}
<div class="modal fade" id="arhiviranjeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-warning">Архивирање/активирање предмета</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите да архивирате/активирате предмет?</h3>
                <p class="text-danger">
                    Ако је предмет активан биће архивиран и обрнуто.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="dugmeModalArhivirajArhiviraj">
                    <i class="fa fa-archive"></i> Архивирај/активирај
                </button>
                <button type="button" class="btn btn-danger" id="dugmeModalArhivirajOtazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_arhiviranje  --}}

{{-- @php(dd($predmet->tuzioci)) --}}
<table class="table table-condensed table-striped" style="table-layout: fixed;">
    <tbody>
        <tr style="font-size: 1.2em">
            <th style="width: 20%;"><strong>Тужилац:</strong></th>
            <td>
                <ul class="list-unstyled">
                    @foreach ($predmet->tuzioci->sortBy('pivot.prioritet') as $s1)
                    <li><span class="text-danger">{{ $s1->pivot->prioritet }}</span> {{ $s1->naziv }} @if($s1->id_broj)<small class="text-success">, ЈМБГ: {{ $s1->id_broj }},</small>@endif
                        @if($s1->adresa) <small class="text-success">Адреса: {{ $s1->adresa }}, </small>@endif
                        @if($s1->mesto) <small class="text-success">Место: {{ $s1->mesto }} </small>@endif
                    </li>
                    @endforeach
                </ul>
            </td>

            <td style="width: 10%;; text-align:right;">
                <a class="btn btn-success btn-xs" id="dugmeKomintenti" href="{{ route('predmet.komintenti', $predmet->id) }}">
                    <i class="fa fa-pencil"></i>
            </td>
        </tr>
        <tr style="font-size: 1.2em">
            <th style="width: 20%;"><strong>Тужени:</strong></th>
            <td>
                <ul class="list-unstyled">
                    @foreach ($predmet->tuzeni->sortBy('pivot.prioritet') as $s2)
                    <li><span class="text-danger">{{ $s2->pivot->prioritet }}</span> {{ $s2->naziv }} @if($s2->id_broj)<small class="text-success">, ЈМБГ: {{ $s2->id_broj }},</small>@endif
                        @if($s2->adresa) <small class="text-success">Адреса: {{ $s2->adresa }}, </small>@endif
                        @if($s2->mesto) <small class="text-success">Место: {{ $s2->mesto }} </small>@endif
                    </li>
                    @endforeach
                </ul>
            </td>
            <td style="width: 10%;; text-align:right;">
                <a class="btn btn-success btn-xs" id="dugmeKomintenti" href="{{ route('predmet.komintenti', $predmet->id) }}">
                    <i class="fa fa-pencil"></i>
            </td>
        </tr>
        <tr style="font-size: 1.2em">
            <th style="width: 20%;"><strong>Надлежни орган:</strong></th>
            <td style="width: 70%;">{{ $predmet->sud->naziv }}</td>
            <td style="width: 10%;"></td>
        </tr>
        <tr style="font-size: 1.2em">
            <th style="width: 20%;"><strong>Надлежни орган број:</strong></th>
            <td style="width: 70%;">
                    @foreach ($predmet->sudBrojevi as $broj)
                        <strong class="text-danger">{{$broj->broj}}<strong> <br>
                    @endforeach</td>
            <td style="width: 10%; text-align:right;"><a class="btn btn-success btn-xs" id="dugmePregledSud" href="{{ route('predmeti.sud_broj', $predmet->id) }}">
                    <i class="fa fa-pencil"></i>
                </a></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Судница:</strong></th>
            <td style="width: 70%;">{{ $predmet->sudnica }}</td>
            <td style="width: 10%;"></td>
        </tr>
         <tr>
            <th style="width: 20%;"><strong>Судија:</strong></th>
            <td style="width: 70%;">{{ $predmet->sudija }}</td>
            <td style="width: 10%;"></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Адвокат:</strong></th>
            <td style="width: 70%;">{{ $predmet->advokat }}</td>
            <td style="width: 10%;"></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Извршитељ:</strong></th>
            <td style="width: 70%;">{{ $predmet->izvrsitelj }}</td>
            <td style="width: 10%;"></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Датум пријема:</strong></th>
            <td style="width: 70%;">{{ date('d.m.Y', strtotime($predmet->datum_tuzbe)) }}</td>
            <td style="width: 10%;"></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Врста предмета:</strong></th>
            <td style="width: 70%;">{{ $predmet->vrstaPredmeta->naziv }}</td>
            <td style="width: 10%;"></td>
        </tr>
{{--         <tr>
            <th style="width: 20%;"><strong>Стари број предмета:</strong></th>
            <td style="width: 70%;">
                @foreach ($predmet->stariBrojevi as $broj)
                {{$broj->broj}} <br>
                @endforeach
            </td>
            <td style="width: 10%; text-align:right;">
                @if (Gate::allows('admin'))
                <a class="btn btn-success btn-xs" id="dugmePregledStari" href="{{ route('predmeti.stari_broj', $predmet->id) }}">
                    <i class="fa fa-pencil"></i>
                </a>
                @endif
            </td>
        </tr> --}}
        <tr>
            <th style="width: 20%;"><strong>Катастарска парцела:</strong></th>
            <td style="width: 70%;">{{ $predmet->opis_kp }}</td>
            <td style="width: 10%;"></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Улица:</strong></th>
            <td style="width: 70%;">{{ $predmet->opis_adresa }}</td>
            <td style="width: 10%;"></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Вредност тужбе:</strong></th>
            <td style="width: 70%;">{{ number_format($predmet->vrednost_tuzbe, 2, ',', '.') }}</td>
            <td style="width: 10%;"></td>
        </tr>

        {{-- Uklonjeno na zahtev korisnika
        <tr>
            <th style="width: 20%;"><strong>Предмет родитељ:</strong></th>
            <td style="width: 70%;">
                @if($predmet->roditelj)
                <a href="{{ route('predmeti.pregled', $predmet->roditelj->id) }}">{{ $predmet->roditelj->broj() }}</a>
                @endif
            </td>
            <td style="width: 10%;"></td>
        </tr> --}}
        <tr>
            <th style="width: 20%;"><strong>Повезани предмети:</strong></th>
            <td style="width: 70%;">
                @if($predmet->vezani->count() > 0)
                <span><i class="fa fa-arrow-circle-o-right" title="ПОВЕЗАН СА"></i></span>
                @foreach($predmet->vezani as $povezani)
                <a href="{{ route('predmeti.pregled', $povezani->id) }}">
                    {{ $povezani->broj() }} &emsp;
                </a>
                @endforeach
                @endif
                &emsp;
                @if($predmet->vezanZa->count() > 0)
                <span><i class="fa fa-arrow-circle-o-up" title="ВЕЗАН ЗА"></i></span>
                @foreach($predmet->vezanZa as $vezan)
                <a href="{{ route('predmeti.pregled', $vezan->id) }}">
                    {{ $vezan->broj() }} &emsp;
                </a>
                @endforeach
                @endif
            </td>
            <td style="width: 10%; text-align:right;">
                <a class="btn btn-success btn-xs" id="dugmePregledVeza" href="{{ route('predmeti.veze', $predmet->id) }}">
                    <i class="fa fa-pencil"></i>
                </a>
            </td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Референт:</strong></th>
            <td style="width: 70%; font-style: italic">{{ $predmet->referent->imePrezime() }}</td>
            <td style="width: 10%; text-align:right;"></td>
        </tr>
        <tr>
            <th style="width: 20%;"><strong>Опис предмета:</strong></th>
            <td style="width: 70%;">{!! nl2br(e($predmet->opis)) !!}</td>
            <td style="width: 10%;"></td>
        </tr>
{{--         <tr> УКЛОЊЕНО НА ЗАХТЕВ КОРИСНИКА
            <th style="width: 20%;"><strong>Напомена:</strong></th>
            <td style="width: 70%;">{!! nl2br(e($predmet->napomena)) !!}</td>
            <td style="width: 10%;"></td>
        </tr> --}}
    </tbody>
</table>
<hr style="border-top: 1px dashed">

{{--  POCETAK TOK_PREDMETA  --}}
@if (Gate::allows('admin'))
    <div class="well" style="overflow: auto;position: relative; z-index: 1000">
@else
<div class="well" style="overflow: auto;">
@endif
    <div class="row" style="margin-top: -20px">
        <div class="col-md-10">
            <h3 style="margin-bottom: 10px">Токови</h3>
        </div>
        <div class="col-md-2">
            <button style="margin-top: 20px"
                    class="btn btn-success btn-sm" id="dugmeDodajStatus"
                    data-toggle="modal" data-target="#dodajStatusModal" value="{{ $predmet->id }}">
                <i class="fa fa-plus-circle"></i> Додај статус/ток
            </button>
        </div>
    </div>

    <hr style="border-top: 1px solid #18BC9C">
    <table class="table table-striped table-condensed table-responsive">
        <thead style="font-size: 0.9375em;">
            <tr>
                <th>Датум</th>
                <th>Статус</th>
                <th>Опис</th>
                <th style="font-size: 0.813em; text-align:right;">Град потражује</th>
                <th style="text-align:right;">Град дугује</th>
                <th style="font-size: 0.813em; text-align:right;" >Трошкови потражује</th>
                <th style="text-align:right;" > Трошкови дугује</th>
                <th class="text-center"><i class="fa fa-cogs"></i></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($predmet->tokovi->sortBy('datum') as $tok)
            <tr>
                <td style="width: 10%;"><strong>{{ date('d.m.Y', strtotime($tok->datum)) }}</strong></td>
                <td style="width: 15%;"><strong class="text-info">{{ $tok->status->naziv }}</strong></td>
                <td style="width: 17%;">{{ str_limit($tok->opis, 30)}}</td>
                <td style="width: 10%;" class="text-right text-success">
                    {{ number_format($tok->vrednost_spora_potrazuje, 2, ',', '.') }}
                </td>
                <td style="width: 12%;"  class="text-right text-danger">
                    {{ number_format($tok->vrednost_spora_duguje, 2, ',', '.') }}
                </td>
                <td style="width: 12%;" class="text-right text-success">
                    {{ number_format($tok->iznos_troskova_potrazuje, 2, ',', '.') }}
                </td>
                <td style="width: 12%;" class="text-right text-danger">
                    {{ number_format($tok->iznos_troskova_duguje, 2, ',', '.') }}
                </td>
                <td style="width: 12%; text-align: right;">
                    <button
                        class="btn btn-success btn-xs" id="dugmeStatusIzmena"
                        data-toggle="modal" data-target="#izmeniStatusModal" value="{{ $tok->id }}">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button
                        class="btn btn-danger btn-xs" id="dugmeStatusBrisanje"
                        value="{{ $tok->id }}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{--  pocetak modal_status_dodavanje  --}}
<div class="modal fade" id="dodajStatusModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-success">Додавање статуса</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('status.dodavanje.post') }}" method="POST" id="frmStatusDodavanje" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('status_dodavanje_status_id') ? ' has-error' : '' }}">
                                <label for="status_dodavanje_status_id">Статус</label>
                                <select name="status_dodavanje_status_id" id="status_dodavanje_status_id" class="chosen-select form-control"
                                        data-placeholder="Статус" required>
                                    <option value=""></option>
                                    @foreach($statusi as $status)
                                    <option value="{{ $status->id }}"{{ old('status_dodavanje_status_id') == $status->id ? ' selected' : '' }}>
                                            {{ $status->naziv }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('status_dodavanje_status_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_dodavanje_status_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('status_dodavanje_datum') ? ' has-error' : '' }}">
                            <label for="status_dodavanje_datum">Датум</label>
                            <input type="date" name="status_dodavanje_datum" id="status_dodavanje_datum" class="form-control"
                                   value="{{ old('status_dodavanje_datum') }}" required>
                            @if ($errors->has('status_dodavanje_datum'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_dodavanje_datum') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('status_dodavanje_vsp') ? ' has-error' : '' }}">
                            <label for="status_dodavanje_vsp">Град потражује</label>
                            <input type="number" name="status_dodavanje_vsp" id="status_dodavanje_vsp" class="form-control"
                                   value="{{ old('status_dodavanje_vsp', 0) }}" step="0.01" required>
                            @if ($errors->has('status_dodavanje_vsp'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_dodavanje_vsp') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('status_dodavanje_vsd') ? ' has-error' : '' }}">
                            <label for="status_dodavanje_vsd">Град дугује</label>
                            <input type="number" name="status_dodavanje_vsd" id="status_dodavanje_vsd" class="form-control"
                                   value="{{ old('status_dodavanje_vsd', 0) }}" step="0.01" required>
                            @if ($errors->has('status_dodavanje_vsd'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_dodavanje_vsd') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('status_dodavanje_itp') ? ' has-error' : '' }}">
                            <label for="status_dodavanje_itp">Износ трошкова потражује</label>
                            <input type="number" name="status_dodavanje_itp" id="status_dodavanje_itp" class="form-control"
                                   value="{{ old('status_dodavanje_itp', 0) }}" step="0.01" required>
                            @if ($errors->has('status_dodavanje_itp'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_dodavanje_itp') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                                        <div class="col-md-3">
                        <div class="form-group{{ $errors->has('status_dodavanje_itd') ? ' has-error' : '' }}">
                            <label for="status_dodavanje_itd">Износ трошкова дугује</label>
                            <input type="number" name="status_dodavanje_itd" id="status_dodavanje_itd" class="form-control"
                                   value="{{ old('status_dodavanje_itd', 0) }}" step="0.01" required>
                            @if ($errors->has('status_dodavanje_itd'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_dodavanje_itd') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('status_dodavanje_opis') ? ' has-error' : '' }}">
                            <label for="status_dodavanje_opis">Опис</label>
                            <textarea name="status_dodavanje_opis" id="status_dodavanje_opis" class="form-control">{{ old('status_dodavanje_opis') }}</textarea>
                            @if ($errors->has('status_dodavanje_opis'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_dodavanje_opis') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="dugmeModalDodajStatus">
                <i class="fa fa-floppy-o"></i> Сними
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-ban"></i> Откажи
            </button>
        </div>
    </div>
</div>
</div>
{{--  kraj modal_status_dodavanje  --}}

{{--  pocetak modal_status_izmena  --}}
<div class="modal fade" id="izmeniStatusModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-warning">Измена статуса</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('status.izmena') }}" method="POST" id="frmStatusIzmena" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_izmena_status_id">Статус</label>
                                <select class="form-control" name="status_izmena_status_id" id="status_izmena_status_id" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status_izmena_datum">Датум</label>
                                <input type="date" class="form-control" id="status_izmena_datum" name="status_izmena_datum" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_izmena_vsp">Град потражује</label>
                                <input type="number" class="form-control" id="status_izmena_vsp" name="status_izmena_vsp" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_izmena_vsd">Град дугује</label>
                                <input type="number" class="form-control" id="status_izmena_vsd" name="status_izmena_vsd" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_izmena_itp">Износ трошкова потражује</label>
                                <input type="number" class="form-control" id="status_izmena_itp" name="status_izmena_itp" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="status_izmena_itd">Износ трошкова дугује</label>
                                <input type="number" class="form-control" id="status_izmena_itd" name="status_izmena_itd" step="0.01" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status_izmena_opis">Опис</label>
                                <textarea class="form-control" id="status_izmena_opis" name="status_izmena_opis"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="tok_id" name="tok_id">
                    <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="dugmeModalIzmeniStatus">
                    <i class="fa fa-floppy-o"></i> Сними
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_status_izmena  --}}

{{--  pocetak modal_status_brisanje  --}}
<div class="modal fade" id="brisanjeStatusModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-danger">Брисање статуса</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите трајно да обришете статус?</h3>
                <h4 id="brisanje_statusa_poruka"></h4>
                <p class="text-danger">Ова акција је неповратна!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="dugmeModalObrisiStatusBrisi">
                    <i class="fa fa-trash"></i> Обриши
                </button>
                <button type="button" class="btn btn-danger" id="dugmeModalObrisiStatusOtazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_status_brisanje  --}}

{{--  KRAJ TOK_PREDMETA  --}}
@endsection

@section('traka')
<div class="row">
    <div class="col-md-6 text-center">
        <a href="{{ route('predmeti.slike', $predmet->id) }}"><img alt="скенирано ..." src="{{url('/images/slike.png')}}" style="height: 64px;"></a>
        <a href="{{ route('predmeti.slike', $predmet->id) }}" class="btn btn-primary" type="button">
            Скенирано <span class="badge">{{$predmet->slike->count()}}</span>
        </a>
    </div>
    <div class="col-md-6 text-center">
        <a href="{{ route('predmeti.podnesci', $predmet->id) }}"><img alt="поднесци ..." src="{{url('/images/ugovor.png')}}" style="height: 64px;"></a>
        <a href="{{ route('predmeti.podnesci', $predmet->id) }}" class="btn btn-primary" type="button">
            Поднесци <span class="badge">{{$predmet->podnesci->count()}}</span>
        </a>
    </div>
</div>
<hr>

{{--  POCETAK ROCISTA  --}}

<div class="well" style="overflow: auto;">
    <div class="row" style="margin-top: -20px">
        <div class="col-md-7">
            <h3 style="margin-bottom: 10px">Рокови/рочишта</h3>
        </div>
        <div class="col-md-5">
            <button style="margin-top: 20px"
                    class="btn btn-success btn-block btn-sm" id="dugmeDodajRociste"
                    data-toggle="modal" data-target="#dodajRocisteModal" value="{{ $predmet->id }}">
                <i class="fa fa-plus-circle"></i> Додај рок/рочиште
            </button>
        </div>
    </div>
    <hr style="border-top: 1px solid #18BC9C">
    <table class="table table-striped table-responsive">
        <tbody>
            @if($rocista)
            @foreach ($rocista as $rociste)
            <tr>
                <td style="width: 20%;"><strong class="text-info">{{ $rociste->tipRocista->naziv }}</strong></td>
                <td style="width: 20%;"><strong>{{ date('d.m.Y', strtotime($rociste->datum)) }}</strong></td>
                <td style="width: 20%;">
                    <strong>
                        {{ $rociste->vreme ? date('H:i', strtotime($rociste->vreme)) : '' }}
                    </strong>
                </td>
                <td style="width: 10%;">
                @if($rociste->tip_id == 2)
                @if($rociste->zamena)
                    <strong>
                        <i class="fa fa-flag" title="{{$rociste->zamena->imePrezime()}}"></i>
                    </strong>
                @endif
                @endif
                </td>
                <td style="width: 30%; text-align: right;">
                    @if($rociste->tip_id == 2)
					<a class="btn btn-success btn-xs" id="dugmeRefZamena" href="{{ route('referenti.zamena', $rociste->id) }}">
                    <i class="fa fa-refresh"></i>
                    </a>
                    @endif
                    <button
                        class="btn btn-success btn-xs" id="dugmeRocisteIzmena"
                        data-toggle="modal" data-target="#izmeniRocisteModal" value="{{$rociste->id}}">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button
                        class="btn btn-danger btn-xs" id="dugmeRocisteBrisanje"
                        value="{{$rociste->id}}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<!--pocetak modal_rocista_dodavanje-->
<div class="modal fade" id="dodajRocisteModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-success">Додавање рока/рочишта</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('rocista.dodavanje.post') }}" method="POST" id="frmRocisteDodavanje" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('rok_dodavanje_tip_id') ? ' has-error' : '' }}">
                                <label for="rok_dodavanje_tip_id">Избор рок/рочишта</label>
                                <select name="rok_dodavanje_tip_id" id="rok_dodavanje_tip_id" class="chosen-select form-control"
                                        data-placeholder="Тип рочишта" required>
                                    <option value=""></option>
                                    @foreach($tipovi_rocista as $tip)
                                    <option value="{{ $tip->id }}"{{ old('rok_dodavanje_tip_id') == $tip->id ? ' selected' : '' }}>
                                            {{ $tip->naziv }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('rok_dodavanje_tip_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rok_dodavanje_tip_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('rok_dodavanje_datum') ? ' has-error' : '' }}">
                                <label for="rok_dodavanje_datum">Датум</label>
                                <input type="date" name="rok_dodavanje_datum" id="rok_dodavanje_datum" class="form-control"
                                       value="{{ old('rok_dodavanje_datum') }}" required>
                                @if ($errors->has('rok_dodavanje_datum'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rok_dodavanje_datum') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4" id="vreme">
                            <div class="form-group{{ $errors->has('rok_dodavanje_vreme') ? ' has-error' : '' }}">
                                <label for="rok_dodavanje_vreme">Време</label>
                                <input type="time" name="rok_dodavanje_vreme" id="rok_dodavanje_vreme" class="form-control"
                                       value="{{ old('rok_dodavanje_vreme') }}">
                                @if ($errors->has('rok_dodavanje_vreme'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rok_dodavanje_vreme') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr style="border-top: 2px solid #18BC9C">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('rok_dodavanje_opis') ? ' has-error' : '' }}">
                                <label for="rok_dodavanje_opis">Опис</label>
                                <textarea name="rok_dodavanje_opis" id="rok_dodavanje_opis" class="form-control">{{old('rok_dodavanje_opis') }}</textarea>
                                @if ($errors->has('rok_dodavanje_opis'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rok_dodavanje_opis') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="dugmeModalDodajRociste">
                    <i class="fa fa-floppy-o"></i> Сними
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_rocista_dodavanje  --}}

{{--  pocetak modal_rocista_izmena  --}}
<div class="modal fade" id="izmeniRocisteModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-warning">Измена рока/рочишта</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('rocista.izmena') }}" method="POST" id="frmRocisteIzmena" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rok_izmena_tip_id">Тип рочишта</label>
                                <select class="form-control" name="rok_izmena_tip_id" id="rok_izmena_tip_id" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rok_izmena_datum">Датум</label>
                                <input type="date" class="form-control" id="rok_izmena_datum" name="rok_izmena_datum" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rok_izmena_vreme">Време</label>
                                <input type="time" class="form-control" id="rok_izmena_vreme" name="rok_izmena_vreme">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="rok_izmena_opis">Опис</label>
                                <textarea class="form-control" id="rok_izmena_opis" name="rok_izmena_opis"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="rok_izmena_id" name="rok_izmena_id">
                    <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="dugmeModalIzmeniRociste">
                    <i class="fa fa-floppy-o"></i> Сними
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_rocista_izmena  --}}

{{--  pocetak modal_rocista_brisanje  --}}
<div class="modal fade" id="brisanjeRocistaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-danger">Брисање рока/рочишта</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите трајно да обришете рок/рочиште?</h3>
                <h4 id="brisanje_roka_poruka"></h4>
                <p class="text-danger">Ова акција је неповратна!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="dugmeModalObrisiRocisteBrisi">
                    <i class="fa fa-trash"></i> Обриши
                </button>
                <button type="button" class="btn btn-danger" id="dugmeModalObrisiRocisteOtazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_rocista_brisanje  --}}

{{--  KRAJ ROCISTA  --}}

{{--  POCETAK KRETANJE  --}}

<div class="well" style="overflow: auto; position: relative; z-index: 1000">
    <div class="row" style="margin-top: -20px">
        <div class="col-md-7">
            <h3 style="margin-bottom: 10px">Кретање предмета</h3>
        </div>
        <div class="col-md-5">
            <button style="margin-top: 20px; z-index: 1000"
                    class="btn btn-success btn-block btn-sm" id="dugmeDodajKretanje"
                    data-toggle="modal" data-target="#dodajKretanjeModal" value="{{ $predmet->id }}">
                <i class="fa fa-plus-circle"></i> Додај кретање
            </button>
        </div>
        <div class="col-md-7">
        </div>
        <div class="col-md-5">
            @if (Auth::user()->level == 100 || Auth::user()->level == 0)
            <button style="margin-top: 20px; z-index: 1000"
                    class="btn btn-warning btn-block btn-sm" id="dugmePromeniLokaciju"
                    data-toggle="modal" data-target="#promenaLokacije" value="{{ $predmet->id }}">
                <i class="fa fa-pencil"></i> Измени локацију
            </button>
            @endif
        </div>
    </div>
    <hr style="border-top: 1px solid #18BC9C;">
    <table class="table table-responsive" style="font-size: 85%;">
        <tbody>
            @foreach ($predmet->kretanja->sortByDesc(function($param){
                return $param->datum.'-'.$param->id;
            }) as $kretanje)
            <tr style="background-color: white">
                <td style="width: 20%;">{{ date('d.m.Y', strtotime($kretanje->datum)) }}</td>
                <td style="width: 1%;"></td>
                <td style="width: 60%;" title="{{$kretanje->opis}}"><strong>{{ str_limit($kretanje->opis, 60)}}</strong></td>
                <td style="width: 19%; text-align: right;">
                    @if (Auth::user()->level == 100 || Auth::user()->level == 0)
                    <button
                        class="btn btn-success btn-xs" id="dugmeKretanjeIzmena"
                        data-toggle="modal" data-target="#izmeniKretanjeModal" value="{{$kretanje->id}}">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button
                        class="btn btn-danger btn-xs" id="dugmeKretanjeBrisanje"
                        value="{{$kretanje->id}}">
                        <i class="fa fa-trash"></i>
                    </button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{--  pocetak modal_promeni_lokaciju  --}}
<div class="modal fade" id="promenaLokacije">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-warning">Измена локације предмета</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('kretanje_predmeti.lokacija.post') }}" method="POST" id="frmPromenaLokacije" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                    <div class="col-md-6">
                            <div class="form-group{{ $errors->has('lokacija_predmeta') ? ' has-error' : '' }}">
                                <label for="lokacija_predmeta">Локација</label>
                                <select name="lokacija_predmeta" id="lokacija_predmeta" class="chosen-select form-control"
                                        data-placeholder="Локација" required>
                                        <option value=""></option>
                                    <option value="1">Датао на коришћење</option>
                                    <option value="0">Враћено у писарницу</option>
                                </select>
                                @if ($errors->has('lokacija_predmeta'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lokacija_predmeta') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="text-warning" style="margin-top: 16px">*Напомена: Користити само у случају брисања или измене ставки кретања како би се ускладила локација из последње ставке у кретању предмета са његовом стварном локацијом !!!</p>
                        </div>

                </div>
                <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" id="dugmePromenaLokacije">
                <i class="fa fa-pencil"></i> Измени
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-ban"></i> Откажи
            </button>
        </div>
    </div>
</div>
</div>
{{--  kraj modal_promeni_lokaciju  --}}

{{--  pocetak modal_kretanje_dodavanje  --}}
<div class="modal fade" id="dodajKretanjeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-success">Додавање кретања</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('kretanje_predmeti.dodavanje.post') }}" method="POST" id="frmKretanjeDodavanje" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                    <div class="col-md-6">
                            <div class="form-group{{ $errors->has('kretanje_dodavanje_smer') ? ' has-error' : '' }}">
                                <label for="kretanje_dodavanje_smer">Смер кретања</label>
                                <select name="kretanje_dodavanje_smer" id="kretanje_dodavanje_smer" class="chosen-select form-control"
                                        data-placeholder="Смер" required>
                                        <option value=""></option>
                                    <option value="1">Датао на коришћење</option>
                                    <option value="0">Враћено у писарницу</option>
                                </select>
                                @if ($errors->has('kretanje_dodavanje_smer'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('kretanje_dodavanje_smer') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                </div>
                <hr style="border-top: 1px solid #18BC9C">
                <div class="row">
        <div class="col-md-6">
        <div class="form-group{{ $errors->has('kretanje_dodavanje_referent_id') ? ' has-error' : '' }}">
            <label for="kretanje_dodavanje_referent_id">Референт:</label>
            <select name="kretanje_dodavanje_referent_id" id="kretanje_dodavanje_referent_id" class="chosen-select form-control" data-placeholder="Референт">
                <option value=""></option>
                @foreach($referenti as $referent)
                <option value="{{ $referent->id }}"{{ old('kretanje_dodavanje_referent_id') == $referent->id ? ' selected' : '' }}>
                        {{ $referent->ime }} {{ $referent->prezime }}
            </option>
            @endforeach
        </select>
        @if ($errors->has('kretanje_dodavanje_referent_id'))
        <span class="help-block">
            <strong>{{ $errors->first('kretanje_dodavanje_referent_id') }}</strong>
        </span>
        @endif
    </div>
</div>
<div class="col-md-6">
                    <p class="text-warning" style="margin-top: 16px">*Напомена: Додати референта само у случају да се њима предмет даје на коришћење</p>
                </div>
                </div>
                <hr style="border-top: 1px solid #18BC9C">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group{{ $errors->has('kretanje_dodavanje_opis') ? ' has-error' : '' }}">
                            <label for="kretanje_dodavanje_opis">Друго лице/лица којима се даје предмет</label>
                            <textarea name="kretanje_dodavanje_opis" id="kretanje_dodavanje_opis" class="form-control">{{old('kretanje_dodavanje_opis') }}</textarea>
                            @if ($errors->has('kretanje_dodavanje_opis'))
                            <span class="help-block">
                                <strong>{{ $errors->first('kretanje_dodavanje_opis') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                    <p class="text-warning" style="margin-top: 16px">*Напомена: Додати у случају да се предмет даје на коришћење неком другом кориснику</p>
                </div>
                </div>
                <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="dugmeModalDodajKretanje">
                <i class="fa fa-plus-circle"></i> Додај
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-ban"></i> Откажи
            </button>
        </div>
    </div>
</div>
</div>
{{--  kraj modal_kretanje_dodavanje  --}}

{{--  pocetak modal_kretanje_izmena  --}}
<div class="modal fade" id="izmeniKretanjeModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-warning">Измена локације</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('kretanje_predmeti.izmena') }}" method="POST" id="frmKretanjeIzmena" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kretanje_izmena_referent_id">Референт:</label>
                                <select class="form-control" name="kretanje_izmena_referent_id" id="kretanje_izmena_referent_id" required>
                                    <option value=""></option>
                                    <option value="0">Навести у опису коме се даје предмет</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kretanje_izmena_opis">Опис / Друго лице/лица којима се даје предмет</label>
                                <textarea class="form-control" id="kretanje_izmena_opis" name="kretanje_izmena_opis"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="kretanje_id" name="kretanje_id">
                    <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="dugmeModalIzmeniKretanje">
                    <i class="fa fa-floppy-o"></i> Сними
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_kretanje_izmena  --}}

{{--  pocetak modal_kretanje_brisanje  --}}
<div class="modal fade" id="brisanjeKretanjeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-danger">Брисање ставке у кретању предмета</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите трајно да обришете ставку у кретању предмета? Тренутна локација предмета неће бити промењена!</h3>
                <h4 id="brisanje_kretanja_poruka"></h4>
                <p class="text-danger">Ова акција је неповратна!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="dugmeModalObrisiKretanjeBrisi">
                    <i class="fa fa-trash"></i> Обриши
                </button>
                <button type="button" class="btn btn-danger" id="dugmeModalObrisiKretanjeOtazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_kretanje_brisanje  --}}

{{--  KRAJ KRETANJE  --}}

{{--  POCETAK UPRAVA  --}}

<div class="well" style="overflow: auto;">
    <div class="row" style="margin-top: -20px">
        <div class="col-md-7">
            <h3 style="margin-bottom: 10px">Управе</h3>
        </div>
        <div class="col-md-5">
            <button style="margin-top: 20px"
                    class="btn btn-success btn-block btn-sm" id="dugmeDodajUpravu"
                    data-toggle="modal" data-target="#dodajUpravuModal" value="{{ $predmet->id }}">
                <i class="fa fa-plus-circle"></i> Додај управу
            </button>
        </div>
    </div>
    <hr style="border-top: 1px solid #18BC9C;">
    <table class="table table-responsive" style="font-size: 85%;">
        <tbody>
            @foreach ($predmet->knjizenja as $knjizenje)
            <tr>
                <td style="width: 20%;">{{ $knjizenje->uprava->sifra }}</td>
                <td style="width: 1%;"></td>
                <td style="width: 79%;"><strong class="text-info">{{ $knjizenje->uprava->naziv }}</strong></td>
            </tr>
            <tr>
                <td style="width: 20%;">{{ date('d.m.Y', strtotime($knjizenje->datum_knjizenja)) }}</td>
                <td style="width: 1%;"></td>
                <td style="width: 79%;" title="{{$knjizenje->napomena}}"><em>{{ str_limit($knjizenje->napomena, 60)}}</em></td>
            </tr>
            <tr class="warning">
                <td style="width: 20%;"></td>
                <td style="width: 1%;"></td>
                <td style="width: 79%; text-align: right;">
                    <button
                        class="btn btn-success btn-xs" id="dugmeUpravaIzmena"
                        data-toggle="modal" data-target="#izmeniUpravuModal" value="{{$knjizenje->id}}">
                        <i class="fa fa-pencil"></i>
                    </button>
                    <button
                        class="btn btn-danger btn-xs" id="dugmeUpravaBrisanje"
                        value="{{$knjizenje->id}}">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{--  pocetak modal_uprava_dodavanje  --}}
<div class="modal fade" id="dodajUpravuModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-success">Додавање управе</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('uprave_predmeti.dodavanje.post') }}" method="POST" id="frmUpravaDodavanje" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group{{ $errors->has('uprava_dodavanje_id') ? ' has-error' : '' }}">
                                <label for="uprava_dodavanje_id">Управа</label>
                                <select name="uprava_dodavanje_id" id="uprava_dodavanje_id" class="chosen-select form-control"
                                        data-placeholder="Управа" required>
                                    <option value=""></option>
                                    @foreach($spisak_uprava as $upr)
                                    <option value="{{ $upr->id }}"{{ old('uprava_dodavanje_id') == $upr->id ? ' selected' : '' }}>
                                            {{ $upr->sifra }} - {{ $upr->naziv }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('uprava_dodavanje_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('uprava_dodavanje_id') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('uprava_dodavanje_datum') ? ' has-error' : '' }}">
                            <label for="uprava_dodavanje_datum">Датум</label>
                            <input type="date" name="uprava_dodavanje_datum" id="uprava_dodavanje_datum" class="form-control"
                                   value="{{ old('uprava_dodavanje_datum') }}" required>
                            @if ($errors->has('uprava_dodavanje_datum'))
                            <span class="help-block">
                                <strong>{{ $errors->first('uprava_dodavanje_datum') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <hr style="border-top: 2px solid #18BC9C">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('uprava_dodavanje_napomena') ? ' has-error' : '' }}">
                            <label for="uprava_dodavanje_napomena">Напомена</label>
                            <textarea name="uprava_dodavanje_napomena" id="uprava_dodavanje_napomena" class="form-control">{{old('uprava_dodavanje_napomena') }}</textarea>
                            @if ($errors->has('uprava_dodavanje_napomena'))
                            <span class="help-block">
                                <strong>{{ $errors->first('uprava_dodavanje_napomena') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" id="dugmeModalDodajUpravu">
                <i class="fa fa-floppy-o"></i> Сними
            </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">
                <i class="fa fa-ban"></i> Откажи
            </button>
        </div>
    </div>
</div>
</div>
{{--  kraj modal_uprava_dodavanje  --}}

{{--  pocetak modal_uprava_izmena  --}}
<div class="modal fade" id="izmeniUpravuModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-warning">Измена управе</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('uprave_predmeti.izmena') }}" method="POST" id="frmUpravaIzmena" data-parsley-validate>
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="uprava_izmena_id">Управа</label>
                                <select class="form-control" name="uprava_izmena_id" id="uprava_izmena_id" required>
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="uprava_izmena_datum">Датум</label>
                                <input type="date" class="form-control" id="uprava_izmena_datum" name="uprava_izmena_datum" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="uprava_izmena_napomena">Напомена</label>
                                <textarea class="form-control" id="uprava_izmena_napomena" name="uprava_izmena_napomena"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="knjizenje_id" name="knjizenje_id">
                    <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="dugmeModalIzmeniUpravu">
                    <i class="fa fa-floppy-o"></i> Сними
                </button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_uprava_izmena  --}}

{{--  pocetak modal_uprava_brisanje  --}}
<div class="modal fade" id="brisanjeUpraveModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-danger">Брисање управе</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите трајно да обришете управу?</h3>
                <h4 id="brisanje_uprave_poruka"></h4>
                <p class="text-danger">Ова акција је неповратна!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="dugmeModalObrisiUpravuBrisi">
                    <i class="fa fa-trash"></i> Обриши
                </button>
                <button type="button" class="btn btn-danger" id="dugmeModalObrisiUpravuOtazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_uprava_brisanje  --}}

{{--  KRAJ UPRAVA  --}}

@if (Gate::allows('admin'))
<div class="panel panel-info">
    <div class="panel-heading">
        <h5>Мета информације о предмету</h4>
    </div>
    <div class="panel-body" style="font-size: 0.938em">
        <p>
            Последњу измену је извршио
            @if ($predmet->korisnik)
                <strong class="text-primary">{{ $predmet->korisnik->name }}</strong>
            @else
                <strong class="text-primary"> корисник који више није активан и обрисан је из базе.</strong>
            @endif
        </p> 
        <p>
            Предмет је додат у базу
            <strong class="text-primary">{{ date('d.m.Y', strtotime($predmet->created_at)) }}</strong>
        </p>
        <p>
            Предмет је последњи пут измењен
            <strong class="text-primary">{{ date('d.m.Y', strtotime($predmet->updated_at)) }}</strong>
        </p>
    </div>
</div>
@endif
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script>
    $(document).ready(function () {

        var rok_detalj_ruta = "{{ route('rocista.detalj') }}";
        var rok_brisanje_ruta = "{{ route('rocista.brisanje') }}";
        var uprava_detalj_ruta = "{{ route('uprave_predmeti.detalj') }}";
        var uprava_brisanje_ruta = "{{ route('uprave_predmeti.brisanje') }}";
        var kretanje_detalj_ruta = "{{ route('kretanje_predmeti.detalj') }}";
        var kretanje_brisanje_ruta = "{{ route('kretanje_predmeti.brisanje') }}";
        var status_detalj_ruta = "{{ route('status.detalj') }}";
        var status_brisanje_ruta = "{{ route('status.brisanje') }}";
        var brisanje_ruta = "{{ route('predmeti.brisanje') }}";
        var arhiviranje_ruta = "{{ route('predmeti.arhiviranje') }}";
        var predmeti_ruta = "{{ route('predmeti') }}";
        var id_predmeta = "{{ $predmet->id }}";


        $("#rok_dodavanje_datum").on('blur', function() {
            var datum = new Date();
            var godina = datum.getFullYear();
            var datumPolja = new Date(this.value);
            var godinaPolja = datumPolja.getFullYear();
            if(godinaPolja < godina){
                alert("Датум који сте унели није из текуће године!");
            }
        });

        // Modal rocista dodavanje
        $('#rok_dodavanje_tip_id').on('change', function() {
                if ( this.value == 2){
                    $('#vreme').show();
                    $('#rok_dodavanje_vreme').prop('required',true);
                }else {
                    $('#vreme').hide();
                }
        });

        $("#dugmeModalDodajRociste").on('click', function () {
            $('#frmRocisteDodavanje').submit();
        });

        // Modal rocista izmene
        $("#dugmeModalIzmeniRociste").on('click', function () {
            $('#frmRocisteIzmena').submit();
        });

        $(document).on('click', '#dugmeRocisteIzmena', function () {
            var id_menjanje = $(this).val();
            $.ajax({
                url: rok_detalj_ruta,
                type: "GET",
                data: {
                    "id": id_menjanje
                },
                success: function (result) {
                    $("#rok_izmena_id").val(result.rociste.id);
                    $("#rok_izmena_datum").val(result.rociste.datum);
                    $("#rok_izmena_vreme").val(result.rociste.vreme);
                    $("#rok_izmena_opis").val(result.rociste.opis);
                    $.each(result.tipovi_rocista, function (index, lokObjekat) {
                        $('#rok_izmena_tip_id').
                                append('<option value="' + lokObjekat.id + '">' + lokObjekat.naziv + '</option>');
                    });
                    $("#rok_izmena_tip_id").val(result.rociste.tip_id);
                }
            });
        });

        // Modal rocista brisanje
        $(document).on('click', '#dugmeRocisteBrisanje', function () {
            var id_brisanje = $(this).val();
            $('#brisanjeRocistaModal').modal('show');
            $('#dugmeModalObrisiRocisteBrisi').on('click', function () {
                $.ajax({
                    url: rok_brisanje_ruta,
                    type: "POST",
                    data: {
                        "id": id_brisanje,
                        _token: "{!! csrf_token() !!}"
                    }
                });
                $('#brisanjeRocistaModal').modal('hide');
            });
            $('#dugmeModalObrisiRocisteOtazi').on('click', function () {
                $('#brisanjeRocistaModal').modal('hide');
            });
        });

        // Modal uprave dodavanje
        $("#dugmeModalDodajUpravu").on('click', function () {
            $('#frmUpravaDodavanje').submit();
        });

        // Modal uprave izmene
        $("#dugmeModalIzmeniUpravu").on('click', function () {
            $('#frmUpravaIzmena').submit();
        });
        $(document).on('click', '#dugmeUpravaIzmena', function () {
            var id_uprava_predmet = $(this).val();
            $.ajax({
                url: uprava_detalj_ruta,
                type: "GET",
                data: {
                    "id": id_uprava_predmet
                },
                success: function (result) {
                    $("#knjizenje_id").val(result.knjizenje.id);
                    $("#uprava_izmena_datum").val(result.knjizenje.datum_knjizenja);
                    $("#uprava_izmena_napomena").val(result.knjizenje.napomena);
                    $.each(result.uprave, function (index, lokObjekat) {
                        $('#uprava_izmena_id').
                                append('<option value="' + lokObjekat.id + '">' + lokObjekat.sifra + ' - ' + lokObjekat.naziv + '</option>');
                    });
                    $("#uprava_izmena_id").val(result.knjizenje.uprava_id);
                }
            });
        });

        // Modal uprave brisanje
        $(document).on('click', '#dugmeUpravaBrisanje', function () {
            var id_brisanje = $(this).val();
            $('#brisanjeUpraveModal').modal('show');
            $('#dugmeModalObrisiUpravuBrisi').on('click', function () {

                $.ajax({
                    url: uprava_brisanje_ruta,
                    type: "POST",
                    data: {
                        "id": id_brisanje,
                        _token: "{!! csrf_token() !!}"
                    },
                    success: function () {
                        location.reload();
                    }
                });
                $('#brisanjeUpraveModal').modal('hide');
            });
            $('#dugmeModalObrisiUpravuOtazi').on('click', function () {
                $('#brisanjeUpraveModal').modal('hide');
            });
        });


        // Modal kretanje dodavanje
        $("#dugmeModalDodajKretanje").on('click', function () {
            $('#frmKretanjeDodavanje').submit();
        });

        // Modal promena lokacije
        $("#dugmePromenaLokacije").on('click', function () {
            $('#frmPromenaLokacije').submit();
        });

        // Modal kretanje izmene
        $("#dugmeModalIzmeniKretanje").on('click', function () {
            $('#frmKretanjeIzmena').submit();
        });
        $(document).on('click', '#dugmeKretanjeIzmena', function () {
            var id_kretanje = $(this).val();
            $('#kretanje_izmena_referent_id').find('option').remove();
            $.ajax({
                url: kretanje_detalj_ruta,
                type: "GET",
                data: {
                    "id": id_kretanje
                },
                success: function (result) {
                    $("#kretanje_id").val(result.kretanje.id);
                    $("#kretanje_izmena_opis").val(result.kretanje.opis);
                     $.each(result.referenti, function (index, lObjekat) {
                        $('#kretanje_izmena_referent_id').
                                append('<option value="' + lObjekat.id + '">' + lObjekat.ime +' '+  lObjekat.prezime +'</option>');
                    });
                     $("#kretanje_izmena_referent_id").val(result.kretanje.referent_id);
                }
            });
        });

        // Modal kretanje brisanje
        $(document).on('click', '#dugmeKretanjeBrisanje', function () {
            var id_brisanje = $(this).val();
            $('#brisanjeKretanjeModal').modal('show');
            $('#dugmeModalObrisiKretanjeBrisi').on('click', function () {

                $.ajax({
                    url: kretanje_brisanje_ruta,
                    type: "POST",
                    data: {
                        "id": id_brisanje,
                        _token: "{!! csrf_token() !!}"
                    },
                    success: function () {
                        location.reload();
                    }
                });
                $('#brisanjeKretanjeModal').modal('hide');
            });
            $('#dugmeModalObrisiKretanjeOtazi').on('click', function () {
                $('#brisanjeKretanjeModal').modal('hide');
            });
        });


        // Modal status dodavanje
        $("#dugmeModalDodajStatus").on('click', function () {
            $('#frmStatusDodavanje').submit();
        });
        // Modal status izmene
        $("#dugmeModalIzmeniStatus").on('click', function () {
            $('#frmStatusIzmena').submit();
        });
        $(document).on('click', '#dugmeStatusIzmena', function () {
            var id_menjanje = $(this).val();
            $.ajax({
                url: status_detalj_ruta,
                type: "GET",
                data: {
                    "id": id_menjanje
                },
                success: function (result) {
                    $("#tok_id").val(result.tok.id);
                    $("#status_izmena_datum").val(moment.utc(result.tok.datum).format("YYYY-MM-DD"));
                    $("#status_izmena_opis").val(result.tok.opis);
                    $("#status_izmena_vsd").val(result.tok.vrednost_spora_duguje);
                    $("#status_izmena_vsp").val(result.tok.vrednost_spora_potrazuje);
                    $("#status_izmena_itd").val(result.tok.iznos_troskova_duguje);
                    $("#status_izmena_itp").val(result.tok.iznos_troskova_potrazuje);
                    $.each(result.statusi, function (index, lokObjekat) {
                        $('#status_izmena_status_id').
                                append('<option value="' + lokObjekat.id + '">' + lokObjekat.naziv + '</option>');
                    });
                    $("#status_izmena_status_id").val(result.tok.status_id);
                }
            });
        });
        // Modal status brisanje
        $(document).on('click', '#dugmeStatusBrisanje', function () {
            var id_brisanje = $(this).val();
            $('#brisanjeStatusModal').modal('show');
            $('#dugmeModalObrisiStatusBrisi').on('click', function () {

                $.ajax({
                    url: status_brisanje_ruta,
                    type: "POST",
                    data: {
                        "id": id_brisanje,
                        _token: "{!! csrf_token() !!}"
                    },
                    success: function () {
                        location.reload();
                    }
                });
                $('#brisanjeStatusModal').modal('hide');
            });
            $('#dugmeModalObrisiStatusOtazi').on('click', function () {
                $('#brisanjeStatusModal').modal('hide');
            });
        });
        // Modal arhiviranje
        $(document).on('click', '#dugmeArhiviranje', function () {

            $('#arhiviranjeModal').modal('show');
            $('#dugmeModalArhivirajArhiviraj').on('click', function () {

                $.ajax({
                    url: arhiviranje_ruta,
                    type: "POST",
                    data: {
                        "id": id_predmeta,
                        _token: "{!! csrf_token() !!}"
                    },
                    success: function () {
                        location.reload();
                    }
                });
                $('#arhiviranjeModal').modal('hide');
            });
            $('#dugmeModalArhivirajOtazi').on('click', function () {
                $('#arhiviranjeModal').modal('hide');
            });
        });


        // Modal brisanje predmeta
        $(document).on('click', '#dugmeBrisanjePredmeta', function () {
            $('#brisanjePredmetaModal').modal('show');
            $('#dugmeModalObrisiPredmetBrisi').on('click', function () {
                $.ajax({
                    url: brisanje_ruta,
                    type: "POST",
                    data: {
                        id: id_predmeta,
                        _token: "{!! csrf_token() !!}"
                    },
                    success: function () {
                        window.location = predmeti_ruta;
                    }
                });
                $('#brisanjePredmetaModal').modal('hide');
            });
            $('#dugmeModalObrisiPredmetOtkazi').on('click', function () {
                $('#brisanjePredmetaModal').modal('hide');
            });
        });
    });



</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection
