@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
        Додавање новог предмета
    </h1>

    <form action="{{ route('predmeti.dodavanje.post') }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}
        <fieldset>
        <legend>Број предмета</legend>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('vrsta_upisnika_id') ? ' has-error' : '' }}">
                    <label for="vrsta_upisnika_id">Врста уписника:</label>
                    <select name="vrsta_upisnika_id" id="vrsta_upisnika_id" class="chosen-select form-control" data-placeholder="Врста уписника" required>
                        <option value=""></option>
                        @foreach($upisnici as $upisnik)
                        <option data-br="{{ $upisnik->sledeci_broj }}"
                        value="{{ $upisnik->id }}"{{ old('vrsta_upisnika_id') == $upisnik->id ? ' selected' : '' }}>
                            {{ $upisnik->slovo }} - {{ $upisnik->naziv }}
                        </option>
                        @endforeach
                    </select>
                    @if ($errors->has('vrsta_upisnika_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('vrsta_upisnika_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('broj_predmeta') ? ' has-error' : '' }}">
                    <label for="broj_predmeta">Број предмета: </label>
                    <input type="number" name="broj_predmeta" id="broj_predmeta" class="form-control"
                    value="{{ old('broj_predmeta') }}" required readonly>
                    @if ($errors->has('broj_predmeta'))
                        <span class="help-block">
                            <strong>{{ $errors->first('broj_predmeta') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('godina_predmeta') ? ' has-error' : '' }}">
                    <label for="godina_predmeta">Година: </label>
                    <input type="number" name="godina_predmeta" id="godina_predmeta" class="form-control"
                    value="{{ old('godina_predmeta') ? old('godina_predmeta') : (int) date('Y', time()) }}"
                    min="1900" max="3000" step="1" required>
                    @if ($errors->has('godina_predmeta'))
                        <span class="help-block">
                            <strong>{{ $errors->first('godina_predmeta') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        </fieldset>
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('sud_id') ? ' has-error' : '' }}">
                    <label for="sud_id">Надлежни суд:</label>
                    <select name="sud_id" id="sud_id" class="chosen-select form-control" data-placeholder="Надлежни суд" required>
                        <option value=""></option>
                        @foreach($sudovi as $sud)
                        <option value="{{ $sud->id }}"{{ old('sud_id') == $sud->id ? ' selected' : '' }}>
                            <strong>{{ $sud->naziv }}</strong>
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
                        <option value="{{ $vrsta->id }}"{{ old('vrsta_predmeta_id') == $vrsta->id ? ' selected' : '' }}>
                            <strong>{{ $vrsta->naziv }}</strong>
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
                    value="{{ old('datum_tuzbe') ? old('datum_tuzbe') : date('Y-m-d', time()) }}" required>
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
                    value="{{ old('stranka_1') }}" required>
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
                    value="{{ old('stranka_2') }}" required>
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
                    value="{{ old('opis_kp') }}" required>
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
                    value="{{ old('opis_adresa') }}" required>
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
                    <textarea name="opis" id="opis" class="form-control" required>{{ old('opis') }}</textarea>
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
            referent_id
            </div>
            <div class="col-md-4">
            vrednost_tuzbe
            </div>
            <div class="col-md-4">
            roditelj_id
            </div>
        </div>


        <input type="submit" value="IDI">
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