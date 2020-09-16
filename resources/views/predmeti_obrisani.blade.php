@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
        Преглед обрисаних предмета
    </h1>

    @if($predmeti->isEmpty())
        <h3 class="text-danger">Нема записа у бази података</h3>
    @else
        <table class="table table-striped tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti" style="table-layout: fixed; font-size: 0.9375em;">
            <thead>
                <tr>
                    <th style="width: 4%;">а/а</th>
                    <th style="width: 6%;">Број</th>
                    <th style="width: 11%;">Суд<span class="text-success"> / </span> број</th>
                    <th style="width: 9%;">Врста предмета</th>
                    <th style="width: 19%;">Опис</th>
                    <th style="width: 14%;">Странка 1</th>
                    <th style="width: 14%;">Странка 2</th>
                    <th style="width: 9%;">Датум</th>
                    <th style="width: 9%;">Референт</th>
                    <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
                </tr>
            </thead>
            <tbody id="predmeti_lista" name="predmeti_lista">
                @foreach ($predmeti as $predmet)
                    <tr>
                        <td style="text-align:center; font-weight: bold; vertical-align: middle; line-height: normal;" class="text-danger">
                            {{ $predmet->arhiviran == 0 ? '' : 'а/а' }}
                        </td>
                        <td style="vertical-align: middle; line-height: normal;">
                            <strong>
                                <a href="{{ route('predmeti.pregled', $predmet->id) }}">
                                    {{ $predmet->broj() }}
                                </a>
                            </strong>
                        </td>
                        <td style="vertical-align: middle; line-height: normal;">
                            <ul style="list-style-type: none; padding-left:1px;">
                                <li>{{$predmet->sud->naziv}}</li>
                                <li><span class="text-success">бр.: </span>{{$predmet->broj_predmeta_sud}}</li>
                            </ul>

                        </td>
                        <td style="vertical-align: middle; line-height: normal;">{{$predmet->vrstaPredmeta->naziv}}</td>
                        <td>
                            <ul style="list-style-type: none; padding-left:1px;">
                                <li>{{$predmet->opis_kp}}</li>
                                <li><span class="text-success">{{$predmet->opis_adresa}}&emsp;</span></li>
                                <li>{{$predmet->opis}}</li>
                            </ul>
                        </td>
                        <td style="vertical-align: middle; line-height: normal;"><em>{{$predmet->stranka_1}}</em></td>
                        <td style="vertical-align: middle; line-height: normal;"><em>{{$predmet->stranka_2}}</em></td>
                        <td style="vertical-align: middle; line-height: normal;">{{ date('d.m.Y', strtotime($predmet->datum_tuzbe))}}</td>
                        <td style="vertical-align: middle; line-height: normal;">{{$predmet->referent->imePrezime()}}</td>
                        <td style="text-align:center">
                            <button class="btn btn-success btn-sm otvori_modal_vracanje"
                                    title="Акривирање обрисаног предмета"
                                    id="dugmeVracanje"
                                    value="{{ $predmet->id }}">
                                <i class="fa fa-undo"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{--  pocetak modal_predmet_vracanje  --}}
    <div class="modal fade" id="vracanjeModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-warning">Активирање обрисаног предмета</h4>
                </div>
                <div class="modal-body">
                    <h4>Да ли желите да активирате обрисани предмет?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="dugmeModalAktiviraj">
                        <i class="fa fa-undo"></i> Активирај
                    </button>
                    <button type="button" class="btn btn-danger" id="dugmeModalOtkazi">
                        <i class="fa fa-ban"></i> Откажи
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--  kraj modal_predmet_vracanje  --}}
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/datetime-moment.js') }}"></script>
<script>
    $.fn.dataTable.moment('DD.MM.YYYY');
    $( document ).ready(function() {
        var ruta_vracanje = "{{ route('predmeti.obrisani.vracanje') }}"

        $('#tabelaPredmeti').DataTable({
            dom: 'Bflrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',{
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4, 5, 6, 7 ]
                    }
                }
            ],
            columnDefs: [{ orderable: false, searchable: false, "targets": -1 }],
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

        // Modal aktiviranje predmeta
        $(document).on('click', '.otvori_modal_vracanje', function() {
            var id = $(this).val();
            $('#vracanjeModal').modal('show');
            $('#dugmeModalAktiviraj').on('click', function() {
                $.ajax({
                    url: ruta_vracanje,
                    type:"POST",
                    data: {"id": id, _token: "{!! csrf_token() !!}"},
                    success: function() {
                        location.reload();
                    }
                });
                $('#vracanjeModal').modal('hide');
            });
            $('#dugmeModalOtkazi').on('click', function() {
                $('#vracanjeModal').modal('hide');
            });
        });
    });
</script>
@endsection