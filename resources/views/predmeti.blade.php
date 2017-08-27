@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
        Преглед предмета укључујући и архивиране предмете
    </h1>
    <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <a class="btn btn-primary" href="{{ route('predmeti.dodavanje.get') }}" style="float: right;">
                <i class="fa fa-plus-circle fa-fw"></i> Нови предмет
            </a>
        </div>
    </div>
    <hr style="border-top: 2px solid #18BC9C">

    @if($predmeti->isEmpty())
            <h3 class="text-danger">Нема записа у бази података</h3>
        @else
            <table class="table table-striped tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="width: 4%;">а/а</th>
                        <th style="width: 6%;">Број</th>
                        <th style="width: 10%;">Врста предмета</th>
                        <th style="width: 25%;">Опис</th>
                        <th style="width: 15%;">Странка 1</th>
                        <th style="width: 15%;">Странка 2</th>
                        <th style="width: 10%;">Датум</th>
                        <th style="width: 10%;">Референт</th>
                        <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody id="predmeti_lista" name="predmeti_lista">
                    @foreach ($predmeti as $predmet)
                        <tr>
                            <td style="text-align:center;" class="text-danger">
                                {{ $predmet->arhiviran == 0 ? '' : 'а/а' }}
                            </td>
                            <td class="text-info">
                                <strong>
                                    {{$predmet->vrstaUpisnika->slovo}} {{$predmet->broj_predmeta}}/{{$predmet->godina_predmeta}}
                                </strong>
                            </td>
                            <td>{{$predmet->vrstaPredmeta->naziv}}</td>
                            <td>{{$predmet->opis_kp}}, {{$predmet->opis_adresa}}, {{$predmet->opis}}</td>
                            <td>{{$predmet->stranka_1}}</td>
                            <td>{{$predmet->stranka_2}}</td>
                            <td>{{$predmet->datum_tuzbe}}</td>
                            <td>{{$predmet->referent->ime}} {{$predmet->referent->prezime}}</td>
                            <td style="text-align:center">
                                <a  class="btn btn-success btn-sm otvori_izmenu"
                                    id="dugmeIzmena"
                                    href="{{ route('predmeti.pregled', $predmet->id) }}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
        <hr style="border-top: 2px solid #18BC9C">
        <div class="row">
        <div class="panel-group" id="accordion"> {{-- Pocetak PANEL GRUPE --}}
        <div class="panel panel-default"> {{-- Pocetak PANELA --}}

    <div class="panel-heading"> {{-- Pocetak naslova panela --}}
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><button class="btn btn-primary"> Додатно филтрирање предмета на основу задатог параметра &emsp;<i class="fa fa-expand" aria-hidden="true"></i></button></a>
      </h4>
    </div> {{-- Kraj naslova panela --}}

    <div id="collapseOne" class="panel-collapse collapse in"> {{-- Pocetak XXX panela --}}
      
      <div class="panel-body"> {{-- Pocetak tela panela --}}
        
        <div class="row"> {{-- Pocetak reda sa naslovima filter --}}

        <div class="col-md-2">
        <h5>Архивиран</h5>
        </div>

        <div class="col-md-2" style="margin-left: 15px">
        <h5>Референт</h5>
        </div>

        <div class="col-md-2" style="margin-left: 15px">
        <h5>Врста предмета</h5>
        </div>

        <div class="col-md-3" style="margin-left: 15px">
        <h5>Суд</h5>
        </div>

        <div class="col-md-2" style="margin-left: 15px">
        <h5>Врста уписника</h5>
        </div>

        </div> {{-- Kraj reda sa naslovima filtera --}}

        <div class="row"> {{-- Pocetak reda sa selektovima --}}

        <form action="#" method="GET" class="col-md-2">
                    {{ csrf_field() }}
                    <div class="row">
            <div class="form-group{{ $errors->has('arhiviran') ? ' has-error' : '' }} col-md-10">
                                <select name="arhiviran" id="arhiviran" class="chosen-select form-control" data-placeholder="Архивирани">
                                    <option value="0"> Архивирани </option>
                                    <option value="1"> Активни </option>
                                </select>
                                @if ($errors->has('arhiviran'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('arhiviran') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter fa-fw"></i></button>
                            </div>
                            </div>
        </form>

        <form action="#" method="GET" class="col-md-2" style="margin-left: 15px">
                    {{ csrf_field() }}
                    <div class="row">
            <div class="form-group{{ $errors->has('referent_id') ? ' has-error' : '' }} col-md-10">
                                <select name="referent_id" id="referent_id" class="chosen-select form-control" data-placeholder="Референти">
                                    <option value=""></option>
                                    @foreach($referenti as $referent)
                                    <option value="{{ $referent->id }}"{{ old('referent_id') == $referent->id ? ' selected' : '' }}>
                                        <strong>{{ $referent->ime }} {{ $referent->prezime }}</strong>
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('referent_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('referent_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter fa-fw"></i></button>
                            </div>
                            </div>
        </form>

        <form action="#" method="GET" class="col-md-2" style="margin-left: 15px">
                    {{ csrf_field() }}
                    <div class="row">
            <div class="form-group{{ $errors->has('vrsta_predemta_id') ? ' has-error' : '' }} col-md-10">
                                <select name="vrsta_predemta_id" id="vrsta_predemta_id" class="chosen-select form-control" data-placeholder="Врсте предмета">
                                    <option value=""></option>
                                    @foreach($vrste as $vrsta)
                                    <option value="{{ $vrsta->id }}"{{ old('vrsta_predemta_id') == $vrsta->id ? ' selected' : '' }}>
                                        <strong>{{ $vrsta->naziv }}</strong>
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('vrsta_predemta_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vrsta_predemta_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter fa-fw"></i></button>
                            </div>
                            </div>
        </form>

        <form action="#" method="GET" class="col-md-3" style="margin-left: 15px">
                    {{ csrf_field() }}
                    <div class="row">
            <div class="form-group{{ $errors->has('sud_id') ? ' has-error' : '' }} col-md-10">
                                <select name="sud_id" id="sud_id" class="chosen-select form-control" data-placeholder="Судови">
                                    <option value=""></option>
                                    @foreach($sudovi as $sud)
                                    <option value="{{ $sud->id }}"{{ old('sud_id') == $sud->id ? ' selected' : '' }}>
                                        <strong>{{ $sud->naziv }}</strong>
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('sud_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sud_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter fa-fw"></i></button>
                            </div>
                            </div>
        </form>

        <form action="#" method="GET" class="col-md-2" style="margin-left: 15px">
                    {{ csrf_field() }}
                    <div class="row">
            <div class="form-group{{ $errors->has('vrsta_upisnika_id') ? ' has-error' : '' }} col-md-10">
                                <select name="vrsta_upisnika_id" id="vrsta_upisnika_id" class="chosen-select form-control" data-placeholder="Уписници">
                                    <option value=""></option>
                                    @foreach($upisnici as $upisnik)
                                    <option value="{{ $upisnik->id }}"{{ old('vrsta_upisnika_id') == $upisnik->id ? ' selected' : '' }}>
                                        <strong>{{ $upisnik->naziv }}</strong>
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('vrsta_upisnika_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vrsta_upisnika_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-2">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter fa-fw"></i></button>
                            </div>
                            </div>
        </form>

        </div> {{-- Kraj reda sa selektovima --}}
        </div> {{-- Kraj tela panela --}}
        </div> {{-- Kraj XXX panela --}}
        </div> {{-- Kraj PANELA --}}
        </div> {{-- Kraj PANEL GRUPE --}}
        </div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {
    $('#tabelaPredmeti').DataTable({
        responsive: true,
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
        }
    });
    $('.chosen-select').chosen({allow_single_deselect: true});
    $('.collapse').collapse();
});
</script>
@endsection