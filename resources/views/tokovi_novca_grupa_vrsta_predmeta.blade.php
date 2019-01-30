@extends('sabloni.app')

@section('naziv', 'Ток новца | Група врста предмета')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
<div class="row">
    <div class="col-md-10">
    <h1>
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца груписани по врсти предмета
    </h1>
        </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a href="{{ route('tok') }}" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Назад на ток предмета</a>
    </div>
</div>
    <div class="row" style="margin-top: 20px">
<div class="col-md-12">
    <br>
@if(count($vrste) < 1)
            <h3 class="text-danger">Тренутно нема предмета у бази података</h3>
        @else
            <table class="table table-condensed table-striped tabelaTokVrsta" name="tabelaTokVrsta" id="tabelaTokVrsta">
                <thead>
                    <th style="width: 28%">Врста предмета</th>
                    <th style="width: 17%">Вредност спора потражује</th>
                    <th style="width: 17%">Вредност спора дугује</th>
                    <th style="width: 17%">Износ трошкова потражује</th>
                    <th style="width: 17%">Износ трошкова дугује</th>
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
    </div>
        </div>
        </div>
@endsection

@section('skripte')
<script src="{{ asset('/js/buttons.print.min.js') }}"></script>
<script>
$( document ).ready(function() {
    $('table.tabelaTokVrsta').DataTable({
                dom: 'Bflrtip',
        buttons: [
            'excelHtml5',
            'print',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                customize : function(doc){
            var colCount = new Array();
           $('#tabelaTokVrsta').find('tbody tr:first-child td').each(function(){
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
                        4
                    ]
                }
            }

        ],
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
