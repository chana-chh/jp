@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца груписани по врсти предмета
    </h1>
    <div class="row" style="margin-top: 50px">
<div class="col-md-10 col-md-offset-1">
@if($vrste->isEmpty())
            <h3 class="text-danger">Тренутно нема предмета у бази података</h3>
        @else
            <table class="table table-striped tabelaTokPredmet" name="tabelaTokPredmet" id="tabelaTokPredmet">
                <thead>
                      <th>Број предмета</th>
                      <th>Вредност спора потражује</th>
                      <th>Вредност спора дугује</th>
                      <th>Износ трошкова потражује</th>
                      <th>Износ трошкова дугује</th>
                      <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="tokovi_predmeti_lista" name="tokovi_predmeti_lista">
                @foreach ($vrste as $vrsta)
                        <tr>
                                <td>{{$vrste_predmeta[($vrsta->vrsta)-1]}} i id {{$vrsta->vrsta}}</td>
                                <td><strong>{{number_format($vrsta->vsp, 2)}}</strong></td>
                                <td><strong>{{number_format($vrsta->vsd, 2)}}</strong></td>
                                <td><strong>{{number_format($vrsta->itp, 2)}}</strong></td>
                                <td><strong>{{number_format($vrsta->itd, 2)}}</strong></td>

                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena"  href="#"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        </div>
        </div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {
    $('table.tabelaTokPredmet').DataTable({
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