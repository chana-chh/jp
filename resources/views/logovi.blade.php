@extends('sabloni.app')

@section('naziv', 'Логови')

@section('meni')
    @include('sabloni.inc.meni')
@endsection



@section('naslov')
    <h1 class="page-header"><img class="slicica_animirana" alt="Логови"
                 src="{{url('/images/log.png')}}" style="height:64px;">
            &emsp;Логови
        </h1>

    @if($logovi->isEmpty())
            <h3 class="text-danger">Тренутно нема убележених логова</h3>
        @else
        <div class="row" style="margin-top: 4rem;">
            <div class="col-md-12">
            <table class="table table-striped tabelaLogovi" name="tabelaLogovi" id="tabelaLogovi">
                <thead>
                      <th style="width: 5%;">#</th>
                      <th style="width: 75%;">Опис</th>
                      <th style="width: 10%;">Датум</th>
                      <th style="width: 10%;">Време</th>
                </thead>
                <tbody id="logovi_lista" name="logovi_lista">
                @foreach ($logovi as $log)
                        <tr>
                                <td>{{$log->id}}</td>
                                <td><strong>{{$log->opis}}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($log->datum)->format('d.m.Y')}}</td>
                                <td>{{ \Carbon\Carbon::parse($log->datum)->format('H:i')}}</td>
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

        $('#tabelaLogovi').DataTable({
            order: [[ 0, "desc" ]],
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