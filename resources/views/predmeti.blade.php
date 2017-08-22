@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Преглед предмета укључујући и архивиране предмете&emsp;<span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span></h1>
            <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <a class="btn btn-primary" href="{{ route('predmeti.dodavanje.get') }}" style="float: right;"><i class="fa fa-plus-circle fa-fw"></i> Нови предмет</a>
        </div>
        </div>
<hr style="border-top: 2px solid #18BC9C">
    @if($predmeti->isEmpty())
            <h3 class="text-danger">Нема записа у бази података</h3>
        @else
            <table class="table table-striped tabelaPredmeti" name="tabelaPredmeti" id="tabelaPredmeti">
                <thead>
                                <th>Архивиран</th>
                                <th>Број предмета</th>
                                <th>Врста предмета</th>
                                <th>Врста уписника</th>
                                <th>Текст (све)</th>
                                <th>Странка 1</th>
                                <th>Странка 2</th>
                                <th>Датум тужбе</th>
                                <th>Референт</th>
                               

                     <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="predmeti_lista" name="predmeti_lista">
                @foreach ($predmeti as $predmet)
                        <tr>
                                         <td style="text-align:center">{!! $predmet->arhiviran == 0 ? '<i class="fa fa-close">' : '<i class="fa fa-check">' !!}</td>
                                         <td><strong>{{$predmet->broj_predmeta}}</strong></td>
                                         <td>{{$predmet->vrstapredmeta->naziv}}</td>
                                         <td>{{$predmet->vrstaupisnika->naziv}}</td>
                                        <td>{{$predmet->tekst_i}}, {{$predmet->tekst_ii}}, {{$predmet->tekst_iii}}</td>
                                        <td>{{$predmet->stranka_i}}</td>
                                        <td>{{$predmet->stranka_ii}}</td>
                                        <td>{{$predmet->datum_tuzbe}}</td>
                                        <td>{{$predmet->referent}}</td>

                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena"  href="{{ route('predmeti.detalj', $predmet->id) }}"><i class="fa fa-eye"></i></a>
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
        responsive: true,
    },
    });
});
</script>
@endsection