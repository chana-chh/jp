@extends('sabloni.app_predmeti')

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

<table class="table table-striped table-condensed tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti">
    <thead>
        <tr>
            <th style="width: 3%">#</th>
            <th style="width: 7%">Статус</th>
            <th style="width: 8%">Број</th>
            <th style="width: 9%">Надлежни орган број</th>
            <th style="width: 14%">Врста предмета</th>
            <th style="width: 15%">Опис</th>
            <th style="width: 18%">Тужилац</th>
            <th style="width: 18%">Тужени</th>
            <th style="width: 5%">Датум</th>
            <th style="width: 3%"><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>

</table>
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/datetime-moment.js') }}"></script>
<script>

$(document).ready(function () {

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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#tabelaPredmeti').DataTable({
        order: [[0, 'desc']],
        lengthMenu: [[10, 25, 50, 250, -1], [10, 25, 50, 250, "Сви"]],
        processing: true,
        serverSide: true,
        ajax: {
            url: '{!! route('predmeti.ajax') !!}',
            type: "POST"
        },
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
                    if (data.st_naziv) {
                        if (data.arhiviran == 0) {
                            return '<span class="status text-primary" style="text-align:center; font-weight: bold; vertical-align: middle; line-height: normal;" data-container="body" data-toggle="popover" data-placement="right" title="Опис:" data-content="' + data.opis + '">' + data.st_naziv + '</span>';
                        } else {
                            return '<span class="status text-danger" style="text-align:center; font-weight: bold; vertical-align: middle; line-height: normal;" data-container="body" data-toggle="popover" data-placement="right" title="Опис:" data-content="' + data.opis + '">' + data.st_naziv + '</span>';
                        }
                    } else {
                        return " ";
                    }

                },
                name: 'st_naziv'
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
                data: 'sudbroj',
                name: 'sudbroj'
            },
            {
                data: 'vp_naziv',
                name: 'vp_naziv'
            },
            {
                data: 'opis_predmeta',
                name: 'opis_predmeta'
            },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.stranka_1) {
                        return '<strong>' + data.stranka_1 + '</strong>'
                    } else {
                        return " "
                    }

                },
                name: 'stranka_1'
            },
            {
                data: null,
                render: function (data, type, row) {
                    if (data.stranka_2) {
                        return '<strong>' + data.stranka_2 + '</strong>'
                    } else {
                        return " "
                    }

                },
                name: 'stranka_2'
            },
            {
                data: 'datum_tuzbe',
                render: function (data, type, row) {
                    return moment(data).format('DD.MM.YYYY');
                },
                name: 'datum_tuzbe'
            },
            {
                data: null,
                className: 'align-middle text-center',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    var ruta = "{{ route('predmeti.pregled', 'data_id') }}";
                    var ruta_id = ruta.replace('data_id', data.id);
                    var referent = data.puno_ime;
                    return '<a class="btn btn-success btn-xs otvori_izmenu" id="dugmeIzmena" title="'+referent+'" href="' + ruta_id + '"><i class="fa fa-eye"></i></a>';
                },
                name: 'akcije'
            }
        ],
        deferRender: true,
        stateSave: true,
        stateSaveCallback: function (settings, data) {
            localStorage.setItem('DataTables_example_state', JSON.stringify(data))
        },
        stateLoadCallback: function (settings) {
            return JSON.parse(localStorage.getItem('DataTables_example_state'))
        },
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
        },

        fnInitComplete: function (oSettings, json) {
            $('.status').popover({
                trigger: 'hover'
            });
        }
    });


    $('#dugme_pretrazi').click(function () {
        $('#pretraga').submit();
    });
});
</script>
@endsection
