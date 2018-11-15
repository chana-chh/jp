@extends('sabloni.app')

@section('naziv', 'Ток новца | Група предмет')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца груписани по предмету
    </h1>
    <div class="row" style="margin-top: 50px">
<div class="col-md-10 col-md-offset-1">
            <table class="table table-striped tabelaTokPredmet" name="tabelaTokPredmet" id="tabelaTokPredmet">
                <thead>
                      <th>Број предмета</th>
                      <th>Вредност спора потражује</th>
                      <th>Вредност спора дугује</th>
                      <th>Износ трошкова потражује</th>
                      <th>Износ трошкова дугује</th>
                      <th>Вредност тужбе</th>
                      <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
{{--                 <tbody id="tokovi_predmeti_lista" name="tokovi_predmeti_lista">
                @foreach ($predmeti as $predmet)
                        <tr>
                                <td>{{$predmet->slovo}}-{{$predmet->broj}}/{{$predmet->godina}}</td>
                                <td><strong>{{number_format($predmet->vsp, 2)}}</strong></td>
                                <td><strong>{{number_format($predmet->vsd, 2)}}</strong></td>
                                <td><strong>{{number_format($predmet->itp, 2)}}</strong></td>
                                <td><strong>{{number_format($predmet->itd, 2)}}</strong></td>
                                <td>{{number_format(($predmet->vrednost_tuzbe), 2)}}</td>

                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu"  href="{{ route('predmeti.pregled', $predmet->id) }}"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                @endforeach
                </tbody> --}}
            </table>

        <div class="row">
    <div class="col-md-12" style="margin-top: 20px">
    <a href="{{ route('tok') }}" class="btn btn-primary pull-right"><i class="fa fa-arrow-circle-left"></i> Назад на ток предмета</a>
    </div>
    </div>
        </div>
        </div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('table.tabelaTokPredmet').DataTable({
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
        render: $.fn.dataTable.render.number( '.', ',', 2 ),
        name: 'vsp'
        },
        {data:'vsd',
        render: $.fn.dataTable.render.number( '.', ',', 2 ),
        name: 'vsd'
        },
        {data:'itp',
        render: $.fn.dataTable.render.number( '.', ',', 2 ),
        name: 'itp'
        },
        {data:'itd',
        render: $.fn.dataTable.render.number( '.', ',', 2 ),
        name: 'itd'
        },
        {data:'vrednost_tuzbe',
        render: $.fn.dataTable.render.number( '.', ',', 2 ),
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