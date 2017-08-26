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

    <form action="{{ route('predmeti.izmena.post', $predmet->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-4">
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
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('datum_tuzbe') ? ' has-error' : '' }}">
                    <label for="datum_tuzbe">Датум предмета:</label>
                    <input type="date" name="datum_tuzbe" id="datum_tuzbe" class="form-control"
                    value="{{ old('datum_tuzbe', $predmet->datum_tuzbe) }}" required>
                    @if ($errors->has('datum_tuzbe'))
                        <span class="help-block">
                            <strong>{{ $errors->first('datum_tuzbe') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <fieldset>
        <legend>Странке</legend>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('stranka_1') ? ' has-error' : '' }}">
                    <label for="stranka_1">Прва странка:</label>
                    <input type="text" name="stranka_1" id="stranka_1" class="form-control"
                    value="{{ old('stranka_1', $predmet->stranka_1) }}" maxlength="255" required>
                    @if ($errors->has('stranka_1'))
                        <span class="help-block">
                            <strong>{{ $errors->first('stranka_1') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('stranka_2') ? ' has-error' : '' }}">
                    <label for="stranka_2">Друга странка:</label>
                    <input type="text" name="stranka_2" id="stranka_2" class="form-control"
                    value="{{ old('stranka_2', $predmet->stranka_2) }}" maxlength="255" required>
                    @if ($errors->has('stranka_2'))
                        <span class="help-block">
                            <strong>{{ $errors->first('stranka_2') }}</strong>
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
            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> Сними</button>
            <a class="btn btn-danger" href="{{route('predmeti.pregled', $predmet->id)}}"><i class="fa fa-ban"></i> Откажи</a>
        </div>
    </form>

@endsection

@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>

<script>
$("#vrsta_upisnika_id").on('change', function() {
    var br = $(this).find(":selected").data("br");
    $("#broj_predmeta").val(br);
});
</script>
@endsection