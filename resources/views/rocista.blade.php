@extends('sabloni.app')

@section('naziv', 'Рочишта')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-6">
        <h1>
            <img class="slicica_animirana" alt="рочиште" src="{{url('/images/rokovi.png')}}" style="height:64px">
            &emsp;Табеларни преглед свих рочишта
        </h1>
    </div>
        <div class="col-md-2 text-right" style="padding-top: 50px;">
        <button id="pretragaDugme" class="btn btn-default btn-block ono">
            <i class="fa fa-search fa-fw"></i> Напредна претрага
        </button>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('rocista.dodavanje.get') }}">
            <i class="fa fa-plus-circle fa-fw"></i> Додај рочиште
        </a>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-success btn-block ono" href="{{ route('rocista.kalendar') }}" ><i class="fa fa-arrow-circle-left"></i> Назад на календарски приказ</a>
    </div>
</div>
<hr style="border-top: 1px solid #18BC9C">
<div id="pretraga_div" class="well" style="display: none;">
    <form id="pretraga" action="{{ route('rocista.pretraga') }}" method="POST">
        {{ csrf_field() }}
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
                       class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label class="text-warning">Напомена</label>
                <p class="text-warning">
                    Ако се унесе само први датум претрага ће се вршити за предмете са тим датумом. Ако се унесу оба датума претрага ће се вршити за предмете између та два датума.
                </p>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-3">
                <label for="tip_id">Тип рочишта</label>
                <select
                    name="tip_id" id="tip_id"
                    class="chosen-select form-control" data-placeholder="Тип рочишта">
                    <option value=""></option>
                    @foreach($tipovi as $tip)
                    <option value="{{ $tip->id }}">
                    <strong>{{ $tip->naziv }}</strong>
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
            <div class="form-group col-md-6 text-right ceo_dva">
                <div class="col-md-6 snimi">
                    <button type="submit" id="dugme_pretrazi" class="btn btn-success btn-block"><i class="fa fa-search"></i>&emsp;Претражи</button>
                </div>
                                <div class="col-md-6">
                    <a class="btn btn-info btn-block" href="{{ route('rocista') }}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
                </div>
            </div>
        </div>
    </form>
</div>

@if($rocista->isEmpty())
<h3 class="text-danger">Нема записа у бази података</h3>
@else
<table class="table table-striped tabelaRocista" name="tabelaRocista" id="tabelaRocista" style="table-layout: fixed;">
    <thead>
        <tr>
            <th style="width: 15%; text-align:right; padding-right: 25px">Број предмета</th>
            <th style="width: 15%; text-align:right; padding-right: 25px">Тип рочишта</th>
            <th style="width: 15%; text-align:right; padding-right: 25px">Датум</th>
            <th style="width: 10%; text-align:right; padding-right: 25px">Време</th>
            <th style="width: 23%; text-align:right; padding-right: 25px">Опис</th>
            <th style="width: 12%; text-align:right; padding-right: 25px">Референт</th>
            <th style="width: 10%; text-align:center"><i class="fa fa-cogs"></i></th>
        </tr>
    </thead>
    <tbody id="rocista_lista" name="rocista_lista">
        @foreach ($rocista as $rociste)
        <tr>
            <td style="text-align:right"><strong>
                    <a href="{{ route('predmeti.pregled', $rociste->predmet_id) }}">
                        {{ $rociste->predmet->broj() }}
                    </a>
                </strong></td>
            <td style="text-align:right">{{$rociste->tipRocista->naziv}}</td>
            <td style="text-align:right"><strong style="color: #18BC9C;">{{ Carbon\Carbon::parse($rociste->datum)->format('d.m.Y') }}</strong></td>
            <td style="text-align:right">{{$rociste->vreme ? date('H:i', strtotime($rociste->vreme)) : ''}}</td>
            <td style="text-align:right"><em>{{$rociste->opis}}</em></td>
            <td style="text-align:right">{{$rociste->predmet->referent->imePrezime()}}</td>
            <td class="text-center">
                <button
                    class="btn btn-success btn-sm" id="dugmeRocisteIzmena"
                    data-toggle="modal" data-target="#izmeniRocisteModal" value="{{$rociste->id}}">
                    <i class="fa fa-pencil"></i>
                </button>
                <button
                    class="btn btn-danger btn-sm" id="dugmeRocisteBrisanje"
                    value="{{$rociste->id}}">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

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
                    <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $rociste->predmet_id }}">
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
    
    $('#pretragaDugme').click(function () {
        $('#pretraga_div').toggle();
        resizeChosen();
    });

    $('#dugme_pretrazi').click(function () {
        $('#pretraga').submit();
    });

    var rok_detalj_ruta = "{{ route('rocista.detalj') }}";
    var rok_brisanje_ruta = "{{ route('rocista.brisanje') }}";

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
                },
                success: function () {
                    location.reload();
                }
            });

            $('#brisanjeRocistaModal').modal('hide');

        });

        $('#dugmeModalObrisiRocisteOtazi').on('click', function () {
            $('#brisanjeRocistaModal').modal('hide');
        });
    });

    $.fn.dataTable.moment('DD.MM.YYYY');

    $('#tabelaRocista').DataTable({
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
                        0,
                        1,
                        2,
                        3,
                        4,
                        5
                    ]
                }
            }

        ],
        order: [
            [
                2,
                "desc"
            ]
        ],
        columnDefs: [
            {
                orderable: false,
                searchable: false,
                "targets": -1
            }
        ],
        responsive: true,
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
});
</script>
@endsection
