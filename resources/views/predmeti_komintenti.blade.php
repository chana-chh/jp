@extends('sabloni.app')

@section('naziv', 'Предмети | Коминзенти')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
        <h1>
            <img class="slicica_animirana" alt="... коминтенти"
                 src="{{url('/images/korisnik.png')}}" style="height:64px;">
            &emsp;Тужиоци / тужени <small class="text-success"><em>({{$predmet->broj()}})</em></small>
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
<h3>Тужиоци</h3>
@if($tuzioci->isEmpty())
<h3 class="text-danger">Тренутно нема тужилаца</h3>
@else
<div class="row" style="margin-top: 4rem;">
    <div class="col-md-12">
        <table class="table table-striped tabelaTuzioci" name="tabelaTuzioci" id="tabelaTuzioci">
            <thead>
            <th style="width: 20%;">Матични број</th>
            <th style="width: 40%;">Име / назив </th>
            <th style="width: 20%;">Место</th>
            <th style="width: 20%;">Телефон</th>
            <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
            </thead>
            <tbody id="tuzioci_lista" name="tuzioci_lista">
                @foreach ($tuzioci as $tuzilac)
                <tr>
                    <td>{{ $tuzilac->id_broj }}</td>
                    <td><strong>{{ $tuzilac->naziv }}</strong></td>
                    <td>{{ $tuzilac->mesto }}</td>
                    <td>{{ $tuzilac->telefon }}</td>

                    <td style="text-align:center">
                        <button id="dugmeBrisanje" class="btn btn-danger btn-xs otvori-brisanje"
                                data-toggle="modal" data-target="#brisanjeModal"
                                value="{{ $tuzilac->id }}" data-tip="1"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<h3>Тужени</h3>
@if($tuzeni->isEmpty())
<h3 class="text-danger">Тренутно нема тужених</h3>
@else
<div class="row" style="margin-top: 4rem;">
    <div class="col-md-12">
        <table class="table table-striped tabelaTuzeni" name="tabelaTuzeni" id="tabelaTuzeni">
            <thead>
            <th style="width: 20%;">Матични број</th>
            <th style="width: 40%;">Име / назив </th>
            <th style="width: 20%;">Место</th>
            <th style="width: 20%;">Телефон</th>
            <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
            </thead>
            <tbody id="tuzeni_lista" name="tuzeni_lista">
                @foreach ($tuzeni as $tuz)
                <tr>
                    <td>{{ $tuz->id_broj }}</td>
                    <td><strong>{{ $tuz->naziv }}</strong></td>
                    <td>{{ $tuz->mesto }}</td>
                    <td>{{ $tuz->telefon }}</td>

                    <td style="text-align:center">
                        <button id="dugmeBrisanje" class="btn btn-danger btn-xs otvori-brisanje"
                                data-toggle="modal" data-target="#brisanjeModal"
                                value="{{ $tuz->id }}" data-tip="2"><i class="fa fa-trash"></i></button>
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
                <h3>Да ли желите да уклоните тужиоца? *</h3>
                <p class = "text-danger">* Ова акција је неповратна!</p>
                <form id="brisanje-forma" action="" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" id="idBrisanje" name="idBrisanje">
                    <input type="hidden" id="tipBrisanje" name="tipBrisanje">
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
<h3 >Повежи тужиоца</h3>
<hr>
<div class="well">
    <form action="{{ route('predmet.komintenti.dodavanje', $predmet->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('tuzilac_id') ? ' has-error' : '' }}">
            <label for="tuzilac_id">Тужилац:</label>
            <select name="tuzilac_id" id="tuzilac_id" class="chosen-select form-control" data-placeholder="коминтенти" required>
                <option value=""></option>
                @foreach($svi_komintenti as $kom)
                <option  value="{{ $kom->id }}"{{ old('tuzilac_id') == $kom->id ? ' selected' : '' }}>
                    {{ $kom->naziv }}, {{ $kom->mesto }} - {{ $kom->id_broj }}</option>
                @endforeach
            </select>
            @if ($errors->has('tuzilac_id'))
            <span class="help-block">
                <strong>{{ $errors->first('tuzilac_id') }}</strong>
            </span>
            @endif
        </div>

        <div class="row dugmici">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-link"></i>&emsp;Додај тужиоца
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{ route('predmet.komintenti', $predmet->id) }}">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<h3 >Повежи туженог</h3>
<hr>
<div class="well">
    <form action="{{ route('predmet.komintenti.dodavanje', $predmet->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('tuzeni_id') ? ' has-error' : '' }}">
            <label for="tuzeni_id">Тужени:</label>
            <select name="tuzeni_id" id="tuzeni_id" class="chosen-select form-control" data-placeholder="коминтенти" required>
                <option value=""></option>
                @foreach($svi_komintenti as $kom)
                <option  value="{{ $kom->id }}"{{ old('tuzeni_id') == $kom->id ? ' selected' : '' }}>
                    {{ $kom->naziv }}, {{ $kom->mesto }} - {{ $kom->id_broj }}</option>
                @endforeach
            </select>
            @if ($errors->has('tuzeni_id'))
            <span class="help-block">
                <strong>{{ $errors->first('tuzeni_id') }}</strong>
            </span>
            @endif
        </div>

        <div class="row dugmici">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-link"></i>&emsp;Додај туженог
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{ route('predmet.komintenti', $predmet->id) }}">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<h3 >Додавање новог коминтента</h3>
<hr>
<div class="well">
    <form action="{{ route('komintenti.dodavanje1') }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
            <label for="naziv">Назив коминтента:</label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv') }}" maxlength="190" required>
            @if ($errors->has('naziv'))
            <span class="help-block">
                <strong>{{ $errors->first('naziv') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('id_broj') ? ' has-error' : '' }}">
            <label for="id_broj">Матични број:</label>
            <input type="text" name="id_broj" id="id_broj" class="form-control" value="{{ old('id_broj') }}" maxlength="20" required>
            @if ($errors->has('id_broj'))
            <span class="help-block">
                <strong>{{ $errors->first('id_broj') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('mesto') ? ' has-error' : '' }}">
            <label for="mesto">Место:</label>
            <input type="text" name="mesto" id="mesto" class="form-control" value="{{ old('mesto') }}" maxlength="255">
            @if ($errors->has('mesto'))
            <span class="help-block">
                <strong>{{ $errors->first('mesto') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('adresa') ? ' has-error' : '' }}">
            <label for="adresa">Адреса:</label>
            <input type="text" name="adresa" id="adresa" class="form-control" value="{{ old('adresa') }}" maxlength="255">
            @if ($errors->has('adresa'))
            <span class="help-block">
                <strong>{{ $errors->first('adresa') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('telefon') ? ' has-error' : '' }}">
            <label for="telefon">Телефон:</label>
            <input type="text" name="telefon" id="telefon" class="form-control" value="{{ old('telefon') }}" maxlength="255">
            @if ($errors->has('telefon'))
            <span class="help-block">
                <strong>{{ $errors->first('telefon') }}</strong>
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
                            <i class="fa fa-plus-circle"></i>&emsp;Додај
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{route('statusi')}}">
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

    $('#tabelaTuzioci').DataTable({
    columnDefs: [{ orderable: false, searchable: false, "targets": - 1 }],
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
    $('#tabelaTuzeni').DataTable({
    columnDefs: [{ orderable: false, searchable: false, "targets": - 1 }],
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
    $(document).on('click', '.otvori-brisanje', function () {
    var id = $(this).val();
    var tip = $(this).data("tip");
    $('#idBrisanje').val(id);
    $('#tipBrisanje').val(tip);
    var ruta = "{{ route('predmet.komintenti.brisanje', "pid") }}";
    ruta = ruta.replace('pid', {!! $predmet->id !!});
    $('#brisanje-forma').attr('action', ruta);
    });
    });</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection
