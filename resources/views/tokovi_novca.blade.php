@extends('sabloni.app')

@section('naziv', 'Ток новца')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Лова
    </h1>
@endsection

@section('sadrzaj')
<h2>Укупно:</h2>
<h3>Сума вредност спорова потраживање: {{$vrednost_spora_potrazuje_suma}}</h3>
<h3>Сума вредност спорова дуг: {{$vrednost_spora_duguje_suma}}</h3>
<h3>Сума износа трошкова потражује: {{$iznos_troskova_potrazuje_suma}}</h3>
<h3>Сума износа трошкова дуг: {{$iznos_troskova_duguje_suma}}</h3>
<hr>
<h2>Овог месеца</h2>
<h3>Сума вредност спорова потраживање: {{$vrednost_spora_potrazuje_mesec}}</h3>
<h3>Сума вредност спорова дуг: {{$vrednost_spora_duguje_mesec}}</h3>
<h3>Сума износа трошкова потражује: {{$iznos_troskova_potrazuje_mesec}}</h3>
<h3>Сума износа трошкова дуг: {{$iznos_troskova_duguje_mesec}}</h3>
<hr>
<h2>Груписано по предмету</h2>
@if($tokovi_predmeti->isEmpty())
            <h3 class="text-danger">Тренутно нема предмета у бази података</h3>
        @else
            <table class="table table-striped tabelaTokPredmet" name="tabelaTokPredmet" id="tabelaTokPredmet">
                <thead>
                      <th>Број предмета</th>
                      <th>Вредност спора потражује</th>
                      <th>Опис</th>
                      <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="tokovi_predmeti_lista" name="tokovi_predmeti_lista">
                @foreach ($tokovi_predmeti as $tok)
                        <tr>
                                <td>{{$vrste_upisnika[($tok->vrsta)-1]}}-{{$tok->broj}}/{{$tok->godina}}</td>
                                <td><strong>{{$tok->vsp}}</strong></td>
                                <td>{{$tok->opis}}</td>

                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena"  href="#"><i class="fa fa-eye"></i></a>
                    <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori_modal"  value="#"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        @foreach ($array as $a)
            <p>{{ $a['mesec'] }} {{ $loop->iteration }}: {{ $a['vrednost_spora_potrazuje'] }}</p>
        @endforeach
@endsection
@section('skripte')
<script>
$( document ).ready(function() {
    $('#tabelaTokPredmet').DataTable({
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