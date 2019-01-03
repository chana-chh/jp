@extends('sabloni.app_predmeti')

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

    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('predmeti') }}">
            <i class="fa fa-minus-circle fa-fw"></i> Уклони филтер
        </a>
    </div>
</div>
<hr>

<table class="table table-striped table-condensed tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti" style="table-layout: fixed; font-size: 0.9375em;">
    <thead>
        <tr>
            <th style="width: 5%; text-align:right; padding-right: 25px">#</th>
            <th style="width: 6%; text-align:right; padding-right: 25px">Статус</th>
            <th style="width: 6%; text-align:right; padding-right: 25px">Број</th>
            <th style="width: 9%; text-align:right; padding-right: 25px">Надлежни орган</th>
            <th style="width: 7%; text-align:right; padding-right: 25px">Број НО</th>
            <th style="width: 10%; text-align:right; padding-right: 25px">Врста предмета</th>
            <th style="width: 12%; text-align:right; padding-right: 25px">Опис</th>
            <th style="width: 13%; text-align:right; padding-right: 25px">Тужилац</th>
            <th style="width: 13%; text-align:right; padding-right: 25px">Тужени</th>
            <th style="width: 5%; text-align:right; padding-right: 25px">Датум</th>
            <th style="width: 9%; text-align:right; padding-right: 25px">Референт</th>
            <th style="text-align: right; width: 5%;"><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
</table>

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
        order: [[0, 'desc']],
        lengthMenu: [[10, 25, 50, 250, -1], [10, 25, 50, 250, "Сви"]],
        processing: true,
        serverSide: true,
        ajax: '{!! route('predmeti.filter') !!}',
        columns: [
            {
                data: null,
                render: function (data, type, row) {

                    return '<small>' + data.id + '</small>'
                },
                name: 'id'
            },
            {
                defaultContent: '',
                data: null,
                render: function (data, type, row) {
                    if (data.arhiviran == 0) {
                        return '<span class="status text-primary" style="text-align:center; font-weight: bold; vertical-align: middle; line-height: normal;">Активан</span>';
                    } else {
                        return '<span class="status text-danger" style="text-align:center; font-weight: bold; vertical-align: middle; line-height: normal;">А/А</span>';
                    }

                },
                name: 'arhiviran'
            },
            {
                data: null,
                className: 'align-middle text-center',
                render: function (data, type, row) {
                    var rutap = "{{ route('predmeti.pregled', 'predmet_id') }}";
                    var rutap_id = rutap.replace('predmet_id', data.id);

                    return '<strong><a href="' + rutap_id + '">' + data.ceo_broj_predmeta + '</a></strong>';
                },
                name: 'ceo_broj_predmeta'
            },
            {
                data: 'sud_naziv',
                name: 'sud_naziv'
            },            
            {
                data: 'sudbroj',
                name: 'sudbroj'
            },
            {
                data: 'vrsta_predmeta',
                name: 'vrsta_predmeta'
            },
            {
                data: 'opis',
                name: 'opis'
            },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.s1) {
                        return '<small><em>' + data.s1 + '</em></small>'
                    } else {
                        return " "
                    }

                },
                name: 's1'
            },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.s2) {
                        return '<small><em>' + data.s2 + '</em></small>'
                    } else {
                        return " "
                    }

                },
                name: 's2'
            },
            {
                data: 'datum_tuzbe',
                render: function (data, type, row) {
                    return moment(data).format('DD.MM.YYYY');
                },
                name: 'datum_tuzbe'
            },
            {
                data: 'referent',
                name: 'referent'
            },
            {
                data: null,
                className: 'align-middle text-center',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    var ruta = "{{ route('predmeti.pregled', 'data_id') }}";
                    var ruta_id = ruta.replace('data_id', data.id);
                    return '<a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena" href="' + ruta_id + '"><i class="fa fa-eye"></i></a>';
                },
                name: 'akcije'
            }
        ],
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
                    40,
                    40,
                    40
                ],
                exportOptions: {
                    columns: [
                        1,
                        2,
                        3,
                        4,
                        5,
                        6,
                        7,
                        8,
                        9,
                        10
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
