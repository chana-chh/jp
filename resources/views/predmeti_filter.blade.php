@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
        <h1>
            <img class="slicica_animirana" alt="предмети"
                 src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Предмети <small class="text-danger"><em>(филтрирани)</em></small>
        </h1>
    </div>
    <!--    <div class="col-md-2 text-right" style="padding-top: 50px;">
            <button id="pretragaDugme" class="btn btn-success btn-block ono">
                <i class="fa fa-search fa-fw"></i> Напредна претрага
            </button>
        </div>-->
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('predmeti') }}">
            <i class="fa fa-minus-circle fa-fw"></i> Уклони филтер
        </a>
    </div>
</div>
<hr>
@if($predmeti->isEmpty())
<h3 class="text-danger">Нема предмета за тражени филтер</h3>
@else
<table class="table table-striped table-condensed tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti" style="table-layout: fixed; font-size: 0.9375em;">
    <thead>
        <tr>
            <th style="width: 4%;">а/а</th>
            <th style="width: 6%;">Број</th>
            <th style="width: 11%;">Суд <span class="text-success">/ </span> број</th>
            <th style="width: 9%;">Врста предмета</th>
            <th style="width: 19%;">Опис</th>
            <th style="width: 14%;">Странка 1</th>
            <th style="width: 14%;">Странка 2</th>
            <th style="width: 9%;">Датум</th>
            <th style="width: 9%;">Референт</th>
            <th style="text-align: right; width: 5%;"><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody id="predmeti_lista" name="predmeti_lista">
        @foreach ($predmeti as $predmet)
        <tr>
            <td class="text-center text-danger">
                <strong>{{ $predmet->arhiviran == 0 ? '' : 'а/а' }}</strong>
            </td>
            <td class="text-center">
                <strong>
                    <a href="{{ route('predmeti.pregled', $predmet->id) }}">
                        {{ $predmet->broj() }}
                    </a>
                </strong>
            </td>
            <td>
                <ul style="list-style-type: none; padding-left:1px;">
                    <li>{{$predmet->sud->naziv}}</li>
                    <li><span class="text-success">бр.: </span>{{$predmet->broj_predmeta_sud}}</li>
                </ul>

            </td>
            <td>{{$predmet->vrstaPredmeta->naziv}}</td>
            <td>
                <ul style="list-style-type: none; padding-left:1px;">
                    <li>{{$predmet->opis_kp}}</li>
                    <li><span class="text-success">{{$predmet->opis_adresa}}&emsp;</span></li>
                    <li>{{$predmet->opis}}</li>
                </ul>
            </td>
            <td><em>{{$predmet->stranka_1}}</em></td>
            <td><em>{{$predmet->stranka_2}}</em></td>
            <td>{{ date('d.m.Y', strtotime($predmet->datum_tuzbe))}}</td>
            <td>{{$predmet->referent->ime}} {{$predmet->referent->prezime}}</td>
            <td class="text-right">
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

    $.fn.dataTable.moment('DD.MM.YYYY');

    $('#pretragaDugme').click(function () {
        $('#pretraga_div').toggle();
    });

    $('#tabelaPredmeti').DataTable({
        dom: 'Bflrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
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
            infoFiltered: "(filtrirano од укупно _MAX_ елемената)",
        }
    });

    $('#dugme_pretrazi').click(function () {
        $('#pretraga').submit();
    });
});
</script>
@endsection
