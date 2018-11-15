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
                    <th>Врста предмета</th>
                    <th>Вредност спора потражује</th>
                    <th>Вредност спора дугује</th>
                    <th>Износ трошкова потражује</th>
                    <th>Износ трошкова дугује</th>
                </thead>
                <tbody id="tokovi_predmeti_lista" name="tokovi_predmeti_lista">
                    @foreach ($vrste as $vrsta)
                    <tr>
                        <td class="text-primary"><h4>{{$vrste_predmeta[($vrsta->vrsta)-1]}}</h4></td>
                        <td><strong>{{number_format($vrsta->vsp, 2)}}</strong></td>
                        <td><strong>{{number_format($vrsta->vsd, 2)}}</strong></td>
                        <td><strong>{{number_format($vrsta->itp, 2)}}</strong></td>
                        <td><strong>{{number_format($vrsta->itd, 2)}}</strong></td>
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
<script>
$( document ).ready(function() {
    $('table.tabelaTokPredmet').DataTable({
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