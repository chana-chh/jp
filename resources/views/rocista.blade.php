@extends('sabloni.app')

@section('naziv', 'Рочишта')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/rokovi.png')}}" style="height:64px"></span>
        Преглед свих рочишта
    </h1>
    <div class="row">
        <div class="col-md-3 col-md-offset-9">
            <a class="btn btn-primary" href="#" style="float: right;">
                <i class="fa fa-plus-circle fa-fw"></i> Додај рочиште
            </a>
        </div>
    </div>
    <hr style="border-top: 2px solid #18BC9C">

    @if($rocista->isEmpty())
            <h3 class="text-danger">Нема записа у бази података</h3>
        @else
            <table class="table table-striped tabelaRocista" name="tabelaRocista" id="tabelaRocista" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="width: 15%;">Тип рочишта</th>
                        <th style="width: 15%;">Датум</th>
                        <th style="width: 20%;">Време</th>
                        <th style="width: 40%;">Опис</th>
                        <th style="width: 10%; text-align:center"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody id="rocista_lista" name="rocista_lista">
                    @foreach ($rocista as $rociste)
                        <tr>
                            <td>{{$rociste->tipRocista->naziv}}</td>
                            <td>{{$rociste->datum}}</td>
                            <td>{{$rociste->vreme}}</td>
                            <td>{{$rociste->opis}}</td>
                            <td style="text-align:center">
                                <a  class="btn btn-success btn-sm otvori_izmenu"
                                    id="dugmeIzmena"
                                    href="{{ route('rocista.pregled', $rociste->id) }}">
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
    $('#tabelaRocista').DataTable({
        order: [[ 1, "desc" ]],
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