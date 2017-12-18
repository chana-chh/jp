@extends('sabloni.app')

@section('naziv', 'Рочишта')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-8">
        <h1>
            <img class="slicica_animirana" alt="рочиште" src="{{url('/images/rokovi.png')}}" style="height:64px">
            &emsp;Табеларни преглед рочишта <small class="text-danger"><em>(филтрирани)</em></small>
        </h1>
    </div>

    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('rocista') }}">
            <i class="fa fa-minus-circle fa-fw"></i> Уклони филтер
        </a>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-success btn-block ono" href="{{ route('rocista.kalendar') }}" ><i class="fa fa-arrow-circle-left"></i> Назад на календарски приказ</a>
    </div>
</div>
<hr style="border-top: 1px solid #18BC9C">

@if($rocista->isEmpty())
<h3 class="text-danger">Нема записа у бази података</h3>
@else
<table class="table table-bordered table-hover tabelaRocista" name="tabelaRocista" id="tabelaRocista" style="table-layout: fixed;">
    <thead>
        <tr>
            <th style="width: 10%; text-align:right; padding-right: 25px">Број предмета</th>
            <th style="width: 7%; text-align:right; padding-right: 25px">Тип рочишта</th>
            <th style="width: 15%; text-align:right; padding-right: 25px">Датум</th>
            <th style="width: 10%; text-align:right; padding-right: 25px">Време</th>
            <th style="width: 24%; text-align:right; padding-right: 25px">Опис</th>
            <th style="width: 12%; text-align:right; padding-right: 25px">Референт</th>
            <th style="width: 22%; text-align:right; padding-right: 25px">Белешке</th>
        </tr>
    </thead>
    <tbody id="rocista_lista" name="rocista_lista">
        @foreach ($rocista as $rociste)
        <tr>
            <td style="text-align:right"><strong>
                    <a href="{{ route('predmeti.pregled', $rociste->id) }}">
                        {{ $rociste->slovo }}-{{ $rociste->broj }}/{{ $rociste->godina }}
                    </a>
                </strong></td>
            <td style="text-align:right">{{$rociste->tip}}</td>
            <td style="text-align:right"><strong style="color: #18BC9C;">{{ Carbon\Carbon::parse($rociste->datum)->format('d.m.Y') }}</strong></td>
            <td style="text-align:right">{{$rociste->vreme ? date('H:i', strtotime($rociste->vreme)) : ''}}</td>
            <td style="text-align:right"><em>{{$rociste->opis}}</em></td>
            <td style="text-align:right">{{$rociste->prezime_referenta}} {{$rociste->ime_referenta}}</td>
            <td >

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/datetime-moment.js') }}"></script>
<script src="{{ asset('/js/buttons.print.min.js') }}"></script>
<script>
$(document).ready(function () {

    $.fn.dataTable.moment('DD.MM.YYYY');

    $('#tabelaRocista').DataTable({
        dom: 'Bflrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'print',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                customize : function(doc){
            var colCount = new Array();
           $('#tabelaRocista').find('tbody tr:first-child td').each(function(){
                if($(this).attr('colspan')){
                    for(var i=1;i<=$(this).attr('colspan');$i++){
                        colCount.push('*');
                    }
                }else{ colCount.push('*'); }
            });
            doc.content[1].table.widths = colCount;
        },
                exportOptions: {
                    columns: [
                        0,
                        1,
                        2,
                        3,
                        4,
                        5,
                        6
                    ]
                }
            }

        ],
        order: [
            [
                2,
                "desc"
            ]
        ],
        columnDefs: [
            {
                orderable: false,
                searchable: false,
                "targets": -1
            }
        ],
        responsive: true,
        language: {
            search: "Пронађи у табели",
            paginate: {
                first: "Прва",
                previous: "Претходна",
                next: "Следећа",
                last: "Последња"
            },
            processing: "Процесирање у току...",
            lengthMenu: "Прикажи _MENU_ елемената",
            zeroRecords: "Није пронађен ниједан запис",
            info: "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
            infoFiltered: "(filtrirano од укупно _MAX_ елемената)",

        }
    });
});
</script>
@endsection
