@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-8">
        <h1>
            <img class="slicica_animirana" alt="предмети"
                 src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Предмети <small><em>(укључујући и архивиране)</em></small>
        </h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <button id="pretragaDugme" class="btn btn-success btn-block ono">
            <i class="fa fa-search fa-fw"></i> Напредна претрага
        </button>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('predmeti.dodavanje.get') }}">
            <i class="fa fa-plus-circle fa-fw"></i> Нови предмет
        </a>
    </div>
</div>
<hr>
<div id="pretraga_div" class="well" style="display: none;">
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
            <div class="form-group col-md-2">
                <label for="broj_predmeta">Број предмета</label>
                <input type="number" min="1" step="1"
                       name="broj_predmeta" id="broj_predmeta"
                       class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="broj_predmeta_sud">Број предмета у суду</label>
                <input type="text" maxlen="50"
                       name="broj_predmeta_sud" id="broj_predmeta_sud"
                       class="form-control">
            </div>
            <div class="form-group col-md-2">
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
                <label for="vrsta_predmeta_id">Врста предмета</label>
                <select
                    name="vrsta_predmeta_id" id="vrsta_predmeta_id"
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
                <label for="stranka_1">Тужилац</label>
                <input type="text" maxlen="255"
                       name="stranka_1" id="stranka_1"
                       class="form-control">
            </div>
            <div class="form-group col-md-6">
                <label for="stranka_2">Тужени</label>
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
            <div class="form-group col-md-4">
                <label for="stari_broj_predmeta">Стари број предмета:</label>
                <input type="text" maxlen="50"
                       name="stari_broj_predmeta" id="stari_broj_predmeta"
                       class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="opis">Датум 1</label>
                <input type="date"
                       name="datum_1" id="datum_1"
                       class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label for="opis">Датум 2</label>
                <input type="date"
                       name="datum_2" id="datum_2"
                       class="form-control" readonly>
            </div>
            <div class="col-md-4">
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
    <div class="row dugmici">
        <div class="col-md-6 col-md-offset-6">
            <div class="form-group text-right ceo_dva">
                <div class="col-md-6 snimi">
                    <button type="submit" id="dugme_pretrazi" class="btn btn-success btn-block"><i class="fa fa-search"></i>&emsp;Претражи</button>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-info btn-block" href="{{ route('predmeti') }}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(count($predmeti) == 0)
<h3 class="text-danger">Нема записа у бази података</h3>
@else
<table class="table table-striped table-condensed tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti" style="table-layout: fixed; font-size: 0.9375em;">
    <thead>
        <tr>
            <th style="width: 8%; text-align:right; padding-right: 25px">Статус </th>
            <th style="width: 6%; text-align:right; padding-right: 25px">Број </th>
            <th style="width: 11%; text-align:right; padding-right: 25px">Суд <span class="text-success">/ </span> број </th>
            <th style="width: 10%; text-align:right; padding-right: 25px">Врста предмета </th>
            <th style="width: 14%; text-align:right; padding-right: 25px">Опис </th>
            <th style="width: 14%; text-align:right; padding-right: 25px">Тужилац </th>
            <th style="width: 14%; text-align:right; padding-right: 25px">Тужени </th>
            <th style="width: 9%; text-align:right; padding-right: 25px">Датум </th>
            <th style="width: 9%; text-align:right; padding-right: 25px">Референт </th>
            <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody id="predmeti_lista" name="predmeti_lista">
        @foreach ($predmeti as $predmet)
        <tr>
            <td style="text-align:center; font-weight: bold; line-height: normal;"
                class="status {{ $predmet->arhiviran == 0 ? 'text-primary' : 'text-danger' }}"
                data-container="body" data-toggle="popover" data-placement="right" title="Опис:" data-content="{{ $predmet->opis() }}" >
                {{-- {{ $predmet->arhiviran == 0 ? '' : 'а/а' }} --}}
                {{ $predmet->status() }}
            </td>
            <td style="text-align:center; line-height: normal;">
                <strong>
                    <a href="{{ route('predmeti.pregled', $predmet->id) }}">
                        {{ $predmet->broj() }}
                    </a>
                </strong>
            </td>
            <td style="line-height: normal; text-align:right">
                <ul style="list-style-type: none; padding-left:1px;">
                    <li>{{$predmet->sud->naziv}}</li>
                    <li><span class="text-success">бр.: </span>{{$predmet->broj_predmeta_sud}}</li>
                </ul>
            </td>
            <td style="line-height: normal; text-align:right">{{$predmet->vrstaPredmeta->naziv}}</td>
            <td>
                <ul style="list-style-type: none; padding-left:1px; text-align:right">
                    <li>{{$predmet->opis}}</li>
                    @if($predmet->opis_kp)
                    <li><span class="text-success">{{ $predmet->opis_kp }}</span></li>
                    @endif
                    @if($predmet->opis_adresa)
                    <li><span class="text-success">{{ $predmet->opis_adresa }}</span></li>
                    @endif
                </ul>
            </td>
            <td style="line-height: normal; text-align:right">
                <ul class="list-unstyled">
                    @foreach ($predmet->tuzioci as $s1)
                    <li>{{ $s1->naziv }}</li>
                    @endforeach
                </ul>
            </td>
            <td style="line-height: normal; text-align:right">
                <ul class="list-unstyled">
                    @foreach ($predmet->tuzeni as $s2)
                    <li>{{ $s2->naziv }}</li>
                    @endforeach
                </ul>
            </td>

            <td style="line-height: normal; text-align:right">{{ date('d.m.Y', strtotime($predmet->datum_tuzbe))}}</td>
            <td style="line-height: normal; text-align:right">{{$predmet->referent->ime}} {{$predmet->referent->prezime}}</td>
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
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/datetime-moment.js') }}"></script>
<script>

$(document).ready(function () {

    $('.status').popover({
        trigger: 'hover'
    });

    jQuery(window).on('resize', resizeChosen);

    $('.chosen-select').chosen({
        allow_single_deselect: true,
        search_contains: true
    });

    function resizeChosen() {
        $(".chosen-container").each(function () {
            $(this).attr('style', 'width: 100%');
        });
    }

    $('#datum_1').on('change', function () {
        if (this.value !== '') {
            $('#datum_2').prop('readonly', false);
        } else {
            $('#datum_2').prop('readonly', true).val('');
        }
    });

    $.fn.dataTable.moment('DD.MM.YYYY');

    $('#pretragaDugme').click(function () {
        $('#pretraga_div').toggle();
        resizeChosen();
    });

    $('#tabelaPredmeti').DataTable({
        stateSave: true,
        dom: 'Bflrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                pageMargins: [
                    40,
                    60,
                    40,
                    60
                ],
                exportOptions: {
                    columns: [
                        1,
                        2,
                        3,
                        4,
                        5,
                        6,
                        7
                    ]
                }
            }

        ],
        columnDefs: [
            {
                orderable: false,
                searchable: false,
                "targets": -1
            }
        ],
        language: {
            search: "Пронађи у табели",
            paginate: {
                first: "Прва",
                previous: "Претходна",
                next: "Следећа",
                last: "Последња"
            },
            processing: "Процесирање у току...",
            lengthMenu: "Прикажи _MENU_ елемената",
            zeroRecords: "Није пронађен ниједан запис",
            info: "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
            infoFiltered: "(filtrirano од укупно _MAX_ елемената)"
        }
    });

    $('#dugme_pretrazi').click(function () {
        $('#pretraga').submit();
    });
});
</script>
@endsection
