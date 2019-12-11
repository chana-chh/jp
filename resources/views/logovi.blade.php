@extends('sabloni.app')

@section('naziv', 'Логови')

@section('meni')
    @include('sabloni.inc.meni')
@endsection



@section('naslov')
<div class="row">
    <div class="col-md-10">
       <h1><img class="slicica_animirana" alt="Логови"
        src="{{url('/images/log.png')}}" style="height:64px;">
            &emsp;Логови
        </h1>
    </div>
</div>

<hr>
        <div class="row" style="margin-top: 4rem;">
            <div class="col-md-12">
            <table class="table table-striped tabelaLogovi" name="tabelaLogovi" id="tabelaLogovi">
                <thead>
                      <th style="width: 5%;">#</th>
                      <th style="width: 75%;">Опис</th>
                      <th style="width: 10%;">Датум</th>
                      <th style="width: 10%;">Време</th>
                </thead>
            </table>
            </div>
        </div>
@endsection


@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/datetime-moment.js') }}"></script>
<script>
$( document ).ready(function() {
    $.fn.dataTable.moment('DD.MM.YYYY');

        $('#tabelaLogovi').DataTable({
            order: [[ 0, "desc" ]],
            lengthMenu: [[10, 25, 100, {!! $logovi !!}], [10, 25, 100, "Сви"]],
                processing: true,
                serverSide: true,
            ajax:{
                     url: "{{ route('ajax.logovi') }}",
                     dataType: "json",
                     type: "POST",
                     data:{ _token: "{{csrf_token()}}"}
                   },
            columns: [
                { "data": "id" },
                { "data": "opis" },
                { "data": "datum" },
                { "data": "vreme" }
            ],
            dom: 'Bflrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4',
                pageMargins: [
                    20,
                    40,
                    20,
                    40
                ], customize: function (doc) {
                    
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
                        1,
                        2,
                        3
                    ]
                }
            }

        ],
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