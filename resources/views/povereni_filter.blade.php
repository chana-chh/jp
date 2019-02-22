@extends('sabloni.app')

@section('naziv', 'Поверени филтер')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <div class="row ne_stampaj">
    <div class="col-md-10">
        <h1><img class="slicica_animirana" alt="Поверени филтер"
                 src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Преглед предмета који се не налазе у писарници <strong class="text-danger">филтрирано</strong>
    </h1>
    </div>
</div>
<hr>
  @if(!$povereni)
            <h3 class="text-danger">Тренутно нема предмета за задате критеријуме</h3>
        @else
        <div class="row" style="margin-top: 4rem;">
            <div class="col-md-12">
            <table class="table table-striped tabelaPovereni" name="tabelaPovereni" id="tabelaPovereni">
                <thead>
                      <th style="width:7%;">#</th>
                      <th style="width:13%;">Број предмета</th>
                      <th style="width:10%;">Датум</th>
                      <th style="width:20%;">Врста предмета</th>
                      <th style="width:15%;">Врста уписника</th>
                      <th style="width:20%;">Тренутна локација</th>
                      <th style="width:15%;text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="korisnici_lista" name="korisnici_lista">
                @foreach ($povereni as $pov)
                <tr>
                    <td>{{$pov->id}}</td>
                    <td><strong>{{$pov->broj}}</strong></td>
                    <td>{{date('d.m.Y', strtotime($pov->poslednji))}}</td>
                    <td>{{$pov->vrsta_predmeta}}</td>
                    <td>{{$pov->vrsta_upisnika}}</td>
                    <td><strong>{{$pov->opis}}</strong></td>
                        <td style="text-align:center">
                        <a class="btn btn-success btn-sm" id="dugmePregled"  href="{{ route('predmeti.pregled', $pov->id) }}"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
        @endif
@endsection


@section('skripte')
<script>
$( document ).ready(function() {

        $('#tabelaPovereni').DataTable({
        columnDefs: [{ orderable: false, searchable: false, "targets": -1 }],
        language: {
        search: "Пронађи у табели",
            paginate: {
            first:      "Прва",
            previous:   "Претходна",
            next:       "Следећа",
            last:       "Последња"
        },
        processing:   "Процесирање у току ...",
        lengthMenu:   "Прикажи _MENU_ елемената",
        zeroRecords:  "Није пронађен ниједан запис за задати критеријум",
        info:         "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
        infoFiltered: "(филтрирано од _MAX_ елемената)",
    },
    });

});
</script>
@endsection