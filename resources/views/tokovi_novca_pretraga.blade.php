@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
@include('sabloni.inc.meni')
@endsection
@section('naslov')
<h1 class="page-header">
    <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
    Резултат претраге
</h1>
<div class="row">
    <div class="col-md-12" style="margin-top: 20px">
        <a href="{{ route('tok') }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-circle-left"></i> Назад на ток предмета</a>
    </div>
</div>
<div class="row" style="margin-top: 50px">
    <div class="col-md-12">
        @if(count($tokovi) === 0)
        <h3 class="text-danger">За овакав упит нема резултата претраге</h3>
        @else
        <table class="table table-striped tabelaTokPredmet" name="tabelaTokPredmet" id="tabelaTokPredmet" style="table-layout: fixed; font-size: 0.9375em;">
            <thead>

            <th style="width: 10%;">Број предмета</th>
            <th style="width: 15%;">Врста предмета</th>
            <th style="width: 15%;">Врста уписника</th>
            <th style="width: 15%;">Вредност спора потражује</th>
            <th style="width: 15%;">Вредност спора дугује</th>
            <th style="width: 15%;">Износ трошкова потражује</th>
            <th style="width: 15%;">Износ трошкова дугује</th>

            <th style="width: 6%; text-align:center"><i class="fa fa-cogs"></i></th>
            </thead>
            <tbody id="tokovi_pretraga_lista" name="tokovi_pretraga_lista">
                @foreach ($tokovi as $tok)
                <tr>
                    <td><a class="text-info" style="font-weight: bold;"  href="{{ route('predmeti.pregled', $tok->id) }}">{{ $tok->broj }}</a></td>
                    <td>{{$tok->vrsta_predmeta}}</td>
                    <td>{{$tok->vrsta_upisnika}}</td>
                    <td>{{number_format(($tok->vsp), 2)}}</td>
                    <td>{{number_format(($tok->vsd), 2)}}</td>
                    <td>{{number_format(($tok->itp), 2)}}</td>
                    <td>{{number_format(($tok->itd), 2)}}</td>

                    <td style="text-align:center">
                        <a class="btn btn-success btn-sm otvori_izmenu"  href="{{ route('predmeti.pregled', $tok->id) }}"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        @endif
    </div>
</div>
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/datetime-moment.js') }}"></script>
<script>
$(document).ready(function () {

    Number.prototype.format = function (n, x, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
                num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    };
    $.fn.dataTable.moment('DD.MM.YYYY');
    var tabela = $('.tabelaTokPredmet').DataTable({
        "footerCallback": function (tfoot, data, start, end, display) {
            var api = this.api(), data;


            var intVal = function (i) {
                return typeof i === 'string' ?
                        i.replace(/[\.,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
            };


            suma_vsp = api.column(3).data().reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
            suma_vsd = api.column(4).data().reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
            suma_itp = api.column(5).data().reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);
            suma_itd = api.column(6).data().reduce(function (a, b) {
                return intVal(a) + intVal(b);
            }, 0);

            var suma_prikaz_vsp = (suma_vsp == 0) ? "0.00" : (suma_vsp / 100).format(2, 3, ',', '.');
            var suma_prikaz_vsd = (suma_vsd == 0) ? "0.00" : (suma_vsd / 100).format(2, 3, ',', '.');
            var suma_prikaz_itp = (suma_itp == 0) ? "0.00" : (suma_itp / 100).format(2, 3, ',', '.');
            var suma_prikaz_itd = (suma_itd == 0) ? "0.00" : (suma_itd / 100).format(2, 3, ',', '.');

            $(api.column(3).footer()).html('Сума: ' + suma_prikaz_vsp);
            $(api.column(4).footer()).html('Сума: ' + suma_prikaz_vsd);
            $(api.column(5).footer()).html('Сума: ' + suma_prikaz_itp);
            $(api.column(6).footer()).html('Сума: ' + suma_prikaz_itd);
        },
        dom: 'Bflrtip',
        buttons: [
            {extend: 'copyHtml5', footer: true},
            {extend: 'excelHtml5', footer: true},
            {extend: 'csvHtml5', footer: true},
            {
                extend: 'pdfHtml5',
                footer: true,
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            }

        ],
        order: [[0, "asc"]],
        columnDefs: [{orderable: false, searchable: false, "targets": -1}],
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
//     var column = tabela.column( 5 );

//     var intVal = function ( i ) {

//                 return typeof i === 'string' ?
//                     i.replace(/[\.,]/g, '')*1 :
//                     typeof i === 'number' ?
//                         i : 0;

//             };

// $( column.footer() ).html(
//     column.data().reduce( function (a,b) {
//         return intVal(a)+intVal(b);
//     } )
// );
});
</script>
@endsection
