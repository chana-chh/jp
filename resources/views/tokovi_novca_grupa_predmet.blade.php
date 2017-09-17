@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца груписани по предмету
    </h1>
    <div class="row" style="margin-top: 50px">
<div class="col-md-10 col-md-offset-1">
    @if($predmeti->isEmpty())
            <h3 class="text-danger">Тренутно нема предмета у бази података</h3>
        @else
            <table class="table table-striped tabelaTokPredmet" name="tabelaTokPredmet" id="tabelaTokPredmet">
                <thead>
                      <th>Број предмета</th>
                      <th>Вредност спора потражује</th>
                      <th>Вредност спора дугује</th>
                      <th>Износ трошкова потражује</th>
                      <th>Износ трошкова дугује</th>
                      <th>Вредност тужбе</th>
                      <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="tokovi_predmeti_lista" name="tokovi_predmeti_lista">
                @foreach ($predmeti as $predmet)
                        <tr>
                                <td>{{$predmet->broj()}}</td>
                                <td><strong>{{number_format($predmet->tokovi->sum('vrednost_spora_potrazuje'), 2)}}</strong></td>
                                <td><strong>{{number_format($predmet->tokovi->sum('vrednost_spora_duguje'), 2)}}</strong></td>
                                <td><strong>{{number_format($predmet->tokovi->sum('iznos_troskova_potrazuje'), 2)}}</strong></td>
                                <td><strong>{{number_format($predmet->tokovi->sum('iznos_troskova_duguje'), 2)}}</strong></td>
                                <td>{{number_format(($predmet->vrednost_tuzbe), 2)}}</td>

                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu"  href="{{ route('predmeti.pregled', $predmet->id) }}"><i class="fa fa-eye"></i></a>
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
<script>
$( document ).ready(function() {
    $('table.tabelaTokPredmet').DataTable({
        order: [[ 1, "desc" ]],
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