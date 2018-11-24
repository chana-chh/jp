@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header">
    <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
    Измена предмета
    <span class="text-success">
        {{ $predmet->vrstaUpisnika->slovo }} {{ $predmet->broj_predmeta }}/{{ $predmet->godina_predmeta }}
    </span>
</h1>

<form id="forma" action="{{ route('predmeti.izmena.post', $predmet->id) }}" method="POST" data-parsley-validate>
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-2">
            <div class="form-group{{ $errors->has('sud_id') ? ' has-error' : '' }}">
                <label for="sud_id">Надлежни суд:</label>
                <select name="sud_id" id="sud_id" class="chosen-select form-control" data-placeholder="Надлежни суд" required>
                    <option value=""></option>
                    @foreach($sudovi as $sud)
                    <option value="{{ $sud->id }}"
                            {{ $sud->id == old('sud_id') ? ' selected' : '' }}
                        {{ $predmet->sud_id == $sud->id ? ' selected' : '' }}>
                        {{ $sud->naziv }}
                    </option>
                    @endforeach
                </select>
                @if ($errors->has('sud_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('sud_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group{{ $errors->has('broj_predmeta_sud') ? ' has-error' : '' }}">
                <label for="broj_predmeta_sud">Број предмета у суду:</label>
                <input type="text" name="broj_predmeta_sud" id="broj_predmeta_sud" class="form-control"
                       value="{{ old('broj_predmeta_sud', $predmet->broj_predmeta_sud) }}" maxlength="50">
                @if ($errors->has('broj_predmeta_sud'))
                <span class="help-block">
                    <strong>{{ $errors->first('broj_predmeta_sud') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group{{ $errors->has('datum_tuzbe') ? ' has-error' : '' }}">
                <label for="datum_tuzbe">Датум предмета (тужбе):</label>
                <input type="date" name="datum_tuzbe" id="datum_tuzbe" class="form-control"
                       value="{{ old('datum_tuzbe', $predmet->datum_tuzbe) }}" required>
                @if ($errors->has('datum_tuzbe'))
                <span class="help-block">
                    <strong>{{ $errors->first('datum_tuzbe') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('vrsta_predmeta_id') ? ' has-error' : '' }}">
                <label for="vrsta_predmeta_id">Врста предмета:</label>
                <select name="vrsta_predmeta_id" id="vrsta_predmeta_id" class="chosen-select form-control" data-placeholder="Врста предмета" required>
                    <option value=""></option>
                    @foreach($vrste as $vrsta)
                    <option value="{{ $vrsta->id }}"
                            {{ $vrsta->id == old('vrsta_predmeta_id') ? ' selected' : '' }}
                        {{ $predmet->vrsta_predmeta_id == $vrsta->id ? ' selected' : '' }}>
                        {{ $vrsta->naziv }}
                    </option>
                    @endforeach
                </select>
                @if ($errors->has('vrsta_predmeta_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('vrsta_predmeta_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('stari_broj_predmeta') ? ' has-error' : '' }}">
                <label for="stari_broj_predmeta">Стари број предмета:</label>
                <input type="text" name="stari_broj_predmeta" id="stari_broj_predmeta" class="form-control"
                       value="{{ old('stari_broj_predmeta', $predmet->stari_broj_predmeta) }}" maxlength="50">
                @if ($errors->has('stari_broj_predmeta'))
                <span class="help-block">
                    <strong>{{ $errors->first('stari_broj_predmeta') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    {{-- dd($predmet->tuzioci) --}}
    <fieldset>
        <legend>Странке</legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('komintenti_1') ? ' has-error' : '' }}">
                    <label for="komintenti_1">Прва странка (тужилац):</label>
                    <select name="komintenti_1[]" id="komintenti_1" class="chosen-select form-control"
                            data-placeholder="Прва странка" multiple>
                        @foreach($komintenti as $kom1)
                        <option value="{{ $kom1->id }}"{{ ($predmet->tuzioci->contains($kom1->id)) ? ' selected' : '' }}>
                            {{ $kom1->naziv }} - {{ $kom1->id_broj }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('komintenti_1'))
                    <span class="help-block">
                        <strong>{{ $errors->first('komintenti_1') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('komintenti_1') ? ' has-error' : '' }}">
                    <label for="komintenti_2">Друга странка (тужени):</label>
                    <select name="komintenti_2[]" id="komintenti_2" class="chosen-select form-control"
                            data-placeholder="Друга странка" multiple>
                        @foreach($komintenti as $kom2)
                        <option value="{{ $kom2->id }}"{{ ($predmet->tuzeni->contains($kom2->id)) ? ' selected' : '' }}>
                            {{ $kom2->naziv }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('komintenti_2'))
                    <span class="help-block">
                        <strong>{{ $errors->first('komintenti_2') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>

    </fieldset>

    <fieldset>
        <legend>Опис предмета</legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('opis_kp') ? ' has-error' : '' }}">
                    <label for="opis_kp">Катастарске парцеле:</label>
                    <input type="text" name="opis_kp" id="opis_kp" class="form-control"
                           value="{{ old('opis_kp', $predmet->opis_kp) }}" maxlength="255">
                    @if ($errors->has('opis_kp'))
                    <span class="help-block">
                        <strong>{{ $errors->first('opis_kp') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('opis_adresa') ? ' has-error' : '' }}">
                    <label for="opis_adresa">Адресе:</label>
                    <input type="text" name="opis_adresa" id="opis_adresa" class="form-control"
                           value="{{ old('opis_adresa', $predmet->opis_adresa) }}" maxlength="255">
                    @if ($errors->has('opis_adresa'))
                    <span class="help-block">
                        <strong>{{ $errors->first('opis_adresa') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('opis') ? ' has-error' : '' }}">
                    <label for="opis">Опис:</label>
                    <textarea name="opis" id="opis" class="form-control">{{ old('opis', $predmet->opis) }}</textarea>
                    @if ($errors->has('opis'))
                    <span class="help-block">
                        <strong>{{ $errors->first('opis') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
    </fieldset>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('referent_id') ? ' has-error' : '' }}">
                <label for="referent_id">Референт:</label>
                <select name="referent_id" id="referent_id" class="chosen-select form-control" data-placeholder="Референт" required>
                    <option value=""></option>
                    @foreach($referenti as $referent)
                    <option value="{{ $referent->id }}"
                            {{ $referent->id == old('referent_id') ? ' selected' : '' }}
                        {{ $predmet->referent_id == $referent->id ? ' selected' : '' }}>
                        {{ $referent->ime }} {{ $referent->prezime }}
                    </option>
                    @endforeach
                </select>
                @if ($errors->has('referent_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('referent_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('vrednost_tuzbe') ? ' has-error' : '' }}">
                <label for="vrednost_tuzbe">Вредност: </label>
                <input type="number" name="vrednost_tuzbe" id="vrednost_tuzbe" class="form-control"
                       min="0" step="0.01"
                       value="{{ old('vrednost_tuzbe', $predmet->vrednost_tuzbe) }}">
                @if ($errors->has('vrednost_tuzbe'))
                <span class="help-block">
                    <strong>{{ $errors->first('vrednost_tuzbe') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('roditelj_id') ? ' has-error' : '' }}">
                <label for="roditelj_id">Предмет родитељ:</label>
                <select name="roditelj_id" id="roditelj_id" class="chosen-select form-control" data-placeholder="Предмет родитељ">
                    <option value=""></option>
                    @foreach($predmeti as $pred)
                    <option value="{{ $pred->id }}"
                            {{ $pred->id == old('roditelj_id') ? ' selected' : '' }}
                        {{ $predmet->roditelj_id == $pred->id ? ' selected' : '' }}>
                        {{ $pred->broj() }}
                    </option>
                    @endforeach
                </select>
                @if ($errors->has('roditelj_id'))
                <span class="help-block">
                    <strong>{{ $errors->first('roditelj_id') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
                <label for="napomena">Напомена:</label>
                <textarea name="napomena" id="napomena" class="form-control">{{ old('napomena', $predmet->napomena) }}</textarea>
                @if ($errors->has('napomena'))
                <span class="help-block">
                    <strong>{{ $errors->first('napomena') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="form-group text-right">
        <button type="button" id="submitModal" data-toggle="modal" data-target="#izmenaPredmetaModal" class="btn btn-success"><i class="fa fa-floppy-o"></i> Сними</button>
        <a class="btn btn-danger" href="{{route('predmeti.pregled', $predmet->id)}}"><i class="fa fa-ban"></i> Откажи</a>
    </div>
</form>

<!--pocetak modal_konfirmacija-->
<div class="modal fade" id="izmenaPredmetaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-danger">Измена предмета</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите да сачувате измене?</h3>
                <div class="izmene"></div>
                <p class="text-danger">Ова акција је неповратна!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" id="dugmeModalIzmeni">
                    <i class="fa fa-floppy-o"></i> Сними
                </button>
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="dugmeModalOtkazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
<!--kraj modal_konfirmacija-->

@endsection

@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>

<script>

var osnovnaVrednoststranka_1 = $("#stranka_1").val();
var osnovnaVrednoststranka_2 = $("#stranka_2").val();

var stranka_1Izmenjena = false;
var stranka_2Izmenjena = false;

$("#stranka_1").on('input', function () {
    var izmenjenaVrednoststranka_1 = $(this).val();
    if (izmenjenaVrednoststranka_1 != osnovnaVrednoststranka_1) {
        stranka_1Izmenjena = true;
    }
});

$("#stranka_2").on('input', function () {
    var izmenjenaVrednoststranka_2 = $(this).val();
    if (izmenjenaVrednoststranka_2 != osnovnaVrednoststranka_2) {
        stranka_2Izmenjena = true;
    }
});


$('#submitModal').click(function () {
    if (stranka_1Izmenjena) {
        $("#izmenaPredmetaModal").find(".izmene").append('<p>' + $('#stranka_1').val() + '</p>');
    }
    if (stranka_2Izmenjena) {
        $("#izmenaPredmetaModal").find(".izmene").append('<p>' + $('#stranka_2').val() + '</p>');
    }
});

$('#dugmeModalIzmeni').click(function () {
    $('#forma').submit();
});

$('#dugmeModalOtkazi').click(function () {
    $('.izmene').empty();
});

$("#vrsta_upisnika_id").on('change', function () {
    var br = $(this).find(":selected").data("br");
    $("#broj_predmeta").val(br);
});

jQuery(window).on('resize', resizeChosen);
$('.chosen-select').chosen({
    allow_single_deselect: true
});
function resizeChosen() {
    $(".chosen-container").each(function () {
        $(this).attr('style', 'width: 100%');
    });
}
</script>
@endsection
