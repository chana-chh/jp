@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
<div class="row">
    <div class="col-md-10">
    <h1>
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца груписани по предмету
    </h1>
        </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a href="{{ route('tok') }}" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Назад на ток предмета</a>
         </div>
     </div>
         <hr>
    <div class="row" style="margin-top: 50px">
<div class="col-md-12">
            <table class="table table-striped tabelaTokPredmet" name="tabelaTokPredmet" id="tabelaTokPredmet">
                <thead>
                     <th>Број предмета</th>
                      <th>Град потражује</th>
                      <th>Град дугује</th>
                      <th>Износ трошкова потражује</th>
                      <th>Износ трошкова дугује</th>
                      <th>Вредност тужбе</th>
                      <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
            <tfoot style="background-color: #666666; color: #dddddd;">
            <tr>
                <td>&emsp; &emsp; &emsp; &Sigma;</td>
                <td>{{number_format($vrednost_spora_potrazuje_suma, 2)}}</td>
                <td>{{number_format($vrednost_spora_duguje_suma, 2)}}</td>
                <td>{{number_format($iznos_troskova_potrazuje_suma, 2)}}</td>
                <td>{{number_format($iznos_troskova_duguje_suma, 2)}}</td>
                <td>{{number_format($vrednost_tuzbe_suma, 2)}}</td>
                <td>&emsp; &emsp; &emsp;</td>
            </tr>
            </tfoot>
            </table>
        </div>
        </div>
@endsection

@section('skripte')
<script src="{{ asset('/js/buttons.print.min.js') }}"></script>
<script>
$( document ).ready(function() {

    var ime_korisnika = {!!json_encode(Auth::user()->name)!!}
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('table.tabelaTokPredmet').DataTable({
        dom: 'Bflrtip',
        buttons: [
            {extend:'excelHtml5',
            footer: true},
            'print',
            {
                extend: 'pdfHtml5',
                messageBottom: {lineHeight: 20, text: 'Укупно:                                         '
                 + String({{$vrednost_spora_potrazuje_suma}}) +
                 '                              ' +
                 String({{$vrednost_spora_duguje_suma}}) +
                 '                             ' +
                 String({{$iznos_troskova_potrazuje_suma}}) +
                 '                                  ' +
                 String({{$iznos_troskova_duguje_suma}}) +
                 '                                  ' +
                 String({{$vrednost_tuzbe_suma}})
             },
                orientation: 'landscape',
                pageSize: 'A4',
                customize : function(doc){
            var colCount = new Array();
           $('#tabelaTokPredmet').find('tbody tr:first-child td').each(function(){
                if($(this).attr('colspan')){
                    for(var i=1;i<=$(this).attr('colspan');$i++){
                        colCount.push('*');
                    }
                }else{ colCount.push('*'); }
            });
            doc.content[1].table.widths = colCount;

            var now = new Date();
                    var jsDate = now.getDate()+'-'+(now.getMonth()+1)+'-'+now.getFullYear();
                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 9;
                    doc['footer']=(function(page, pages) {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        text: ['дана: ', { text: jsDate.toString() }]
                                    },
                                    {
                                        alignment: 'center',
                                        text: ['страна ', { text: page.toString() },  ' од ', { text: pages.toString() }]
                                    },
                                    {
                                        alignment: 'right',
                                        text: ['Документ креиран од стране: ', { text: ime_korisnika.toString() }]
                                    }
                                ],
                                margin: 20
                            }
                        });
        },
                exportOptions: {
                    columns: [
                        0,
                        1,
                        2,
                        3,
                        4,
                        5
                    ]
                }
            }

        ],
        lengthMenu: [[10, 50, 100, -1], [10, 50, 100, "Сви"]],
        processing: true,
        serverSide: true,
        ajax:{url: '{!! route('tok.ajax') !!}',
        type: "POST"},
        columns: [
        {data: null,
        className:'align-middle text-center',
        render: function(data, type, row){
                var rutap = "{{ route('predmeti.pregled', 'predmet_id') }}";
                var rutap_id = rutap.replace('predmet_id', data.idp);
            
            return '<strong><a href="'+rutap_id+'">'+data.slovo+'-'+data.broj+'/'+data.godina+'</a></strong>';
        },name: 'broj'},
        {data:'vsp',
        render: $.fn.dataTable.render.number( ',', '.', 2 ),
        name: 'vsp'
        },
        {data:'vsd',
        render: $.fn.dataTable.render.number( ',', '.', 2 ),
        name: 'vsd'
        },
        {data:'itp',
        render: $.fn.dataTable.render.number( ',', '.', 2 ),
        name: 'itp'
        },
        {data:'itd',
        render: $.fn.dataTable.render.number( ',', '.', 2 ),
        name: 'itd'
        },
        {data:'vrednost_tuzbe',
        render: $.fn.dataTable.render.number( ',', '.', 2 ),
        name: 'vrednost_tuzbe'
        },
        {data: null,
        className:'align-middle text-center',
        render: function(data, type, row){
                var rutap = "{{ route('predmeti.pregled', 'predmet_id') }}";
                var rutap_id = rutap.replace('predmet_id', data.idp);
                return '<a class="btn btn-success btn-sm otvori_izmenu"  href="'+rutap_id+'"><i class="fa fa-eye"></i></a>';
        },name: 'akcije'}
        ],
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