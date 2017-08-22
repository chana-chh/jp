@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        Преглед предмета укључујући и архивиране предмете &emsp;
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
    </h1>
    <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <a class="btn btn-primary" href="{{ route('predmeti.dodavanje.get') }}" style="float: right;">
                <i class="fa fa-plus-circle fa-fw"></i> Нови предмет
            </a>
        </div>
    </div>
    <hr style="border-top: 2px solid #18BC9C">

    @if($predmeti->isEmpty())
            <h3 class="text-danger">Нема записа у бази података</h3>
        @else
            <table class="table table-striped tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="width: 4%;">а/а</th>
                        {{--  <th style="width: 10%;">Врста уписника</th>  --}}
                        <th style="width: 6%;">Број</th>
                        <th style="width: 10%;">Врста предмета</th>
                        <th style="width: 25%;">Опис</th>
                        <th style="width: 15%;">Странка 1</th>
                        <th style="width: 15%;">Странка 2</th>
                        <th style="width: 10%;">Датум</th>
                        <th style="width: 10%;">Референт</th>
                        <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody id="predmeti_lista" name="predmeti_lista">
                    @foreach ($predmeti as $predmet)
                        <tr>
                            <td style="text-align:center;" class="text-danger">
                            {{--  <i class="fa fa-close">  <i class="fa fa-check">  --}}
                                {!! $predmet->arhiviran == 0 ? '' : 'а/а' !!}
                            </td>
                            {{--  <td>{{$predmet->vrstaUpisnika->slovo}}</td>  --}}
                            <td>
                                <strong>
                                    {{$predmet->vrstaUpisnika->slovo}} {{$predmet->broj_predmeta}}/{{$predmet->godina_predmeta}}
                                </strong>
                            </td>
                            <td>{{$predmet->vrstaPredmeta->naziv}}</td>
                            <td>{{$predmet->opis_kp}}, {{$predmet->opis_adresa}}, {{$predmet->opis}}</td>
                            <td>{{$predmet->stranka_1}}</td>
                            <td>{{$predmet->stranka_2}}</td>
                            <td>{{$predmet->datum_tuzbe}}</td>
                            <td>{{$predmet->referent->ime}} {{$predmet->referent->prezime}}</td>
                            <td style="text-align:center">
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
<script>
$( document ).ready(function() {
    $('#tabelaPredmeti').DataTable({
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
            responsive: true
        }
    });
});
</script>
@endsection