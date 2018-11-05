@extends('sabloni.app')

@section('naziv', 'Предмети | Везе')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
        <h1>
            <img class="slicica_animirana" alt="... везе"
                 src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Повезани предмети <small class="text-success"><em>({{$predmet->broj()}})</em></small>
        </h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a href="{{ route('predmeti.pregled', $predmet->id) }}" class="btn btn-primary btn-block ono">
            <i class="fa fa-arrow-circle-left"></i> Назад на предмет
        </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <hr>
    </div>
</div>
@endsection

@section('sadrzaj')
@if($vezan_sa->isEmpty())
<h3 class="text-danger">Тренутно нема повезаних предмета</h3>
@else
<div class="row" style="margin-top: 4rem;">
    <div class="col-md-12">
        <table class="table table-striped tabelaVeze" name="tabelaVeze" id="tabelaVeze">
            <thead>
            <th style="width: 20%;">Статус </th>
            <th style="width: 20%;">Број </th>
            <th style="width: 20%;">Врста предмета </th>
            <th style="width: 15%;">Датум </th>
            <th style="width: 20%;">Референт </th>
            <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
            </thead>
            <tbody id="sudovi_lista" name="sudovi_lista">
                @foreach ($vezan_sa as $v)
                <tr>
                    <td>{{$v->status()}}</td>
                    <td><strong>{{$v->broj()}}</strong></td>
                    <td>{{$v->vrstaPredmeta->naziv}}</td>
                    <td>{{date('d.m.Y', strtotime($v->datum_tuzbe))}}</td>
                    <td>{{$v->referent->ime}} {{$v->referent->prezime}}</td>

                    <td style="text-align:center">
                        <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori-brisanje"
                                data-toggle="modal" data-target="#brisanjeModal"
                                value="{{$v->id}}"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Modal za dijalog brisanje--}}
<div id = "brisanjeModal" class = "modal fade">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <button class = "close" data-dismiss = "modal">&times;</button>
                <h1 class = "modal-title text-danger">Упозорење!</h1>
            </div>
            <div class = "modal-body">
                <h3>Да ли желите трајно да уклоните везу? *</h3>
                <p class = "text-danger">* Ова акција је неповратна!</p>
                <form id="brisanje-forma" action="" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" id="idBrisanje" name="idBrisanje">
                    <hr style="margin-top: 30px;">

                    <div class="row dugmici" style="margin-top: 30px;">
                        <div class="col-md-12" >
                            <div class="form-group">
                                <div class="col-md-6 snimi">
                                    <button id = "btn-brisanje-obrisi" type="submit" class="btn btn-danger btn-block ono">
                                        <i class="fa fa-recycle"></i>&emsp;Уклони
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-primary btn-block ono" data-dismiss="modal">
                                        <i class="fa fa-ban"></i>&emsp;Откажи
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- Kraj Modala za dijalog brisanje--}}
@endsection

@section('traka')
<h3 >Повежи предмет</h3>
<hr>
<div class="well">
    <form action="{{ route('predmeti.veze.dodavanje', $predmet->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('veza_id') ? ' has-error' : '' }}">
            <label for="veza_id">Предмет:</label>
            <select name="veza_id" id="veza_id" class="chosen-select form-control" data-placeholder="предмети за повезивање" required>
                <option value=""></option>
                @foreach($svi_predmeti as $pred)
                <option  value="{{ $pred->id }}"{{ old('veza_id') == $pred->id ? ' selected' : '' }}>
                         {{ $pred->broj() }} - {{ $pred->vrstaPredmeta->naziv }}, {{date('d.m.Y', strtotime($pred->datum_tuzbe))}}</option>
                @endforeach
            </select>
            @if ($errors->has('veza_id'))
            <span class="help-block">
                <strong>{{ $errors->first('veza_id') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
            <label for="napomena">Напомена: </label>
            <textarea name="napomena" id="napomena" maxlength="255" class="form-control">{{ old('napomena') }}</textarea>
            @if ($errors->has('napomena'))
            <span class="help-block">
                <strong>{{ $errors->first('napomena') }}</strong>
            </span>
            @endif
        </div>

        <div class="row dugmici">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-link"></i>&emsp;Повежи
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{ route('predmeti.veze', $predmet->id) }}">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('skripte')
<script>
    $(document).ready(function() {

    jQuery(window).on('resize', resizeChosen);
    $('.chosen-select').chosen({
    allow_single_deselect: true
    });
    function resizeChosen() {
    $(".chosen-container").each(function () {
    $(this).attr('style', 'width: 100%');
    });
    }

    $('#tabelaVeze').DataTable({
    columnDefs: [{ orderable: false, searchable: false, "targets": - 1 }],
            language: {
            search: "Пронађи у таблеи",
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
    $(document).on('click', '.otvori-brisanje', function () {
    var id = $(this).val();
    $('#idBrisanje').val(id);
    var ruta = "{{ route('predmeti.veze.brisanje', "pid") }}";
    ruta = ruta.replace('pid', {!! $predmet->id !!});
    console.log(ruta);
    console.log(id);
    $('#brisanje-forma').attr('action', ruta);
    });
    });</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection
