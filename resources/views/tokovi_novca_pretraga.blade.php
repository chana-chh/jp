@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Резултат претраге
    </h1>
    <div class="row" style="margin-top: 50px">
<div class="col-md-12">
    @if($tokovi->isEmpty())
            <h3 class="text-danger">За овакав упит нема резултата претраге</h3>
        @else
            <table class="table table-striped tabelaTokPredmet" name="tabelaTokPredmet" id="tabelaTokPredmet" style="table-layout: fixed; font-size: 0.9375em;">
                <thead>

                      <th style="width: 7%;">Број предмета</th>
                      <th style="width: 13%;">Врста предмета</th>
                      <th style="width: 12%;">Врста уписника</th>
                      <th style="width: 6%;">Датум</th>
                      <th style="width: 14%;">Вредност спора потражује</th>
                      <th style="width: 14%;">Вредност спора дугује</th>
                      <th style="width: 14%;">Износ трошкова потражује</th>
                      <th style="width: 14%;">Износ трошкова дугује</th>

                      <th style="width: 6%; text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="tokovi_pretraga_lista" name="tokovi_pretraga_lista">
                @foreach ($tokovi as $tok)
                        <tr>

                                <td class="text-primary" style="vertical-align: middle; line-height: normal;">{{$tok->slovo}}-{{$tok->broj}}/{{$tok->godina}}</td>
                                <td>{{$tok->vrsta_predmeta}}</td>
                                <td>{{$tok->vrsta_upisnika}}</td>
                                <td>{{date('d.m.Y', strtotime($tok->datum))}}</td>
                                <td><strong>{{number_format(($tok->vsp), 2)}}</strong></td>
                                <td><strong>{{number_format(($tok->vsd), 2)}}</strong></td>
                                <td><strong>{{number_format(($tok->itp), 2)}}</strong></td>
                                <td><strong>{{number_format(($tok->itd), 2)}}</strong></td>

                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu"  href="{{ route('predmeti.pregled', $tok->id) }}"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <div class="row">
    <div class="col-md-12" style="margin-top: 20px">
    <a href="{{ route('tok') }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-circle-left"></i> Назад на ток предмета</a>
    </div>
    </div>
        </div>
        </div>
@endsection

@section('skripte')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.16/sorting/datetime-moment.js"></script>
<script>
$( document ).ready(function() {
    $.fn.dataTable.moment('DD.MM.YYYY');
    $('table.tabelaTokPredmet').DataTable({
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
        order: [[ 0, "asc" ]],
        columnDefs: [{ orderable: false, searchable: false, "targets": -1 }],
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
     });
</script>
@endsection