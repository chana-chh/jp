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
                                {{ $predmet->broj() }}
                            </strong>
                        </td>
                        <td>{{$predmet->vrstaPredmeta->naziv}}</td>
                        <td>{{$predmet->opis_kp}}, {{$predmet->opis_adresa}}, {{$predmet->opis}}</td>
                        <td>{{$predmet->stranka_1}}</td>
                        <td>{{$predmet->stranka_2}}</td>
                        <td>{{ date('d.m.Y', strtotime($predmet->datum_tuzbe))}}</td>
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










    <div class="panel-group" id="accordion"> {{-- Pocetak PANEL GRUPE --}}
        <div class="panel panel-default"> {{-- Pocetak PANELA --}}
            <div class="panel-heading"> {{-- Pocetak naslova panela --}}
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <button class="btn btn-primary">
                            <i class="fa fa-search"></i> Напредна претрага
                        </button>
                        <a href="{{ route('predmeti') }}" class="btn btn-info">
                            <i class="fa fa-ban"></i> Поништи филтер
                        </a>
                    </a>
                </h4>
            </div> {{-- Kraj naslova panela --}}

            <div id="collapseOne" class="panel-collapse collapse in"> {{-- Pocetak XXX panela --}}
                <div class="panel-body"> {{-- Pocetak tela panela --}}
                    <form id="pretraga" action="{{ route('predmeti.pretraga') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="arhiviran">Архива</label>
                                <select
                                    name="arhiviran" id="arhiviran"
                                    class="chosen-select form-control" data-placeholder="Архива">
                                    <option value=""></option>
                                    <option value="0">Активни</option>
                                    <option value="1">Архивирани</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="vrsta_upisnika_id">Врста уписника</label>
                                <select
                                    name="vrsta_upisnika_id" id="vrsta_upisnika_id"
                                    class="chosen-select form-control" data-placeholder="Врста уписника">
                                    <option value=""></option>
                                    @foreach($upisnici as $upisnik)
                                    <option value="{{ $upisnik->id }}">
                                        <strong>{{ $upisnik->naziv }}</strong>
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="broj_predmeta">Број предмета</label>
                                <input type="number" min="1" step="1"
                                    name="broj_predmeta" id="broj_predmeta"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="godina_predmeta">Година предмета</label>
                                <input type="number" min="1900" step="1"
                                    name="godina_predmeta" id="godina_predmeta"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="sud_id">Суд</label>
                                <select
                                    name="sud_id" id="sud_id"
                                    class="chosen-select form-control" data-placeholder="Суд">
                                        <option value=""></option>
                                        @foreach($sudovi as $sud)
                                        <option value="{{ $sud->id }}">
                                            {{ $sud->naziv }}
                                        </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="vrsta_predemta_id">Врста предмета</label>
                                <select
                                    name="vrsta_predemta_id" id="vrsta_predemta_id"
                                    class="chosen-select form-control" data-placeholder="Врста предмета">
                                        <option value=""></option>
                                        @foreach($vrste as $vrsta)
                                        <option value="{{ $vrsta->id }}">
                                            {{ $vrsta->naziv }}
                                        </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="referent_id">Референт</label>
                                <select
                                    name="referent_id" id="referent_id"
                                    class="chosen-select form-control" data-placeholder="Референт">
                                        <option value=""></option>
                                        @foreach($referenti as $referent)
                                        <option value="{{ $referent->id }}">
                                            {{ $referent->imePrezime() }}
                                        </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="vrednost_tuzbe">Вредност</label>
                                <input type="number" min="0" step="0.01"
                                name="vrednost_tuzbe" id="vrednost_tuzbe"
                                class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="stranka_1">Старнка 1</label>
                                <input type="text" maxlen="255"
                                    name="stranka_1" id="stranka_1"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="stranka_2">Старнка 2</label>
                                <input type="text" maxlen="255"
                                    name="stranka_2" id="stranka_2"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="opis_kp">Катастарска парцела</label>
                                <input type="text" maxlen="255"
                                    name="opis_kp" id="opis_kp"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="opis_adresa">Адреса</label>
                                <input type="text" maxlen="255"
                                    name="opis_adresa" id="opis_adresa"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="opis">Опис предмета</label>
                                <textarea
                                    name="opis" id="opis"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="opis">Датум 1</label>
                                <input type="date"
                                    name="datum_1" id="datum_1"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="opis">Датум 2</label>
                                <input type="date"
                                    name="datum_2" id="datum_2"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="text-warning">Напомена</label>
                                <p class="text-warning">
                                    Ако се унесе само први датум претрага ће се вршити за предмете са тим датумом. Ако се унесу оба датума претрага ће се вршити за предмете између та два датума.
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="napomena">Напомена</label>
                                <textarea
                                    name="napomena" id="napomena"
                                    class="form-control"></textarea>
                            </div>
                        </div>
                    </form>
                </div> {{-- Kraj tela panela --}}
                <div class="panel-footer text-right">
                    <button id="dugme_pretrazi" class="btn btn-success"><i class="fa fa-search"></i> Претражи</button>
                </div>
            </div> {{-- Kraj XXX panela --}}
        </div> {{-- Kraj PANELA --}}
    </div> {{-- Kraj PANEL GRUPE --}}
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

    $('#dugme_pretrazi').click(function() {
        $('#pretraga').submit();
    });

</script>
@endsection