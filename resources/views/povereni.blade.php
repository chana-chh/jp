@extends('sabloni.app')

@section('naziv', 'Поверени')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <div class="row ne_stampaj">
    <div class="col-md-10">
        <h1><img class="slicica_animirana" alt="Поверени"
                 src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Преглед предмета који се не налазе у писарници
    </h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 40px;">
        <button id="pretragaDugme" class="btn btn-default btn-block ono">
            <i class="fa fa-filter fa-fw"></i> Филтер
        </button>
    </div>
</div>
<hr>
<div id="pretraga_div" class="well" style="display: none;">
    <form id="pretraga" action="{{ route('kretanje_predmeti.filter') }}" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-md-3">
                <label for="referent_id">Коме је предмет предат на коришћење</label>
                <select
                    name="referent_id" id="referent_id"
                    class="chosen-select form-control" data-placeholder="Коме је предмет предат на коришћење" required>
                    <option value=""></option>
                    <option value="0">Поверено другом лицу</option>
                    @foreach($referenti as $referent)
                    <option value="{{ $referent->id }}">
                        {{ $referent->imePrezime() }}
                    </option>
                    @endforeach
                </select>
            </div>
                        <div class="form-group col-md-3">

            </div>
            <div class="form-group col-md-6 text-right ceo_dva">
                <div class="col-md-6 snimi">
                    <button type="submit" id="dugme_pretrazi" class="btn btn-success btn-block"><i class="fa fa-filter"></i>&emsp;Примени филтер</button>
                </div>
                                <div class="col-md-6">
                    <a class="btn btn-info btn-block" href="{{ route('kretanje_predmeti.lista') }}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
                </div>
            </div>
        </div>
    </form>
</div>

  @if($povereni->isEmpty())
            <h3 class="text-danger">Тренутно нема предмета који се не налазе у писарници</h3>
        @else
        <div class="row" style="margin-top: 4rem;">
            <div class="col-md-12">
            <table class="table table-striped tabelaPovereni" name="tabelaPovereni" id="tabelaPovereni">
                <thead>
                      <th style="width:10%;">#</th>
                      <th style="width:20%;">Број предмета</th>
                      <th style="width:55%;">Кретање предмета</th>
                      <th style="width:15%;text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="korisnici_lista" name="korisnici_lista">
                @foreach ($povereni as $pov)
                <tr>
                    <td>{{$pov->id}}</td>
                    <td><strong>{{$pov->broj()}}</strong></td>
                    <td>
                        <ul class="list-group">
                        @foreach($pov->kretanja as $kret)
                        <li class="list-group-item">{{$kret->opis}}, {{date('d.m.Y', strtotime($kret->datum))}}</li>
                        @endforeach
                        </ul>
                    </td>
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

        jQuery(window).on('resize', resizeChosen);

        $('.chosen-select').chosen({
            allow_single_deselect: true,
            search_contains: true
        });

        function resizeChosen() {
            $(".chosen-container").each(function () {
                $(this).attr('style', 'width: 100%');
            });
        };

        $('#pretragaDugme').click(function () {
        $('#pretraga_div').toggle();
        resizeChosen();
    });

    $('#dugme_pretrazi').click(function () {
        $('#pretraga').submit();
    });

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
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection