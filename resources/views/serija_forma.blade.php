@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header">
    <i class="fa fa-indent fa-fw"></i>&emsp;
    Додавање нових предмета у серији
</h1>
@endsection
@section('sadrzaj')
<form action="{{ route('predmeti.serija.post') }}" method="POST" id="forma-dodavanje" data-parsley-validate>
    {{ csrf_field() }}
            <div class="row">
            <div class="col-md-4">
                <div class="form-group{{ $errors->has('broj_serija') ? ' has-error' : '' }}">
                    <label for="broj_serija">Број предмета у серији:</label>
                    <select name="broj_serija" id="broj_serija" class="chosen-select form-control" data-placeholder="Број предмета у серији" required>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                    </select>
                    @if ($errors->has('broj_serija'))
                    <span class="help-block">
                        <strong>{{ $errors->first('broj_serija') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
        </div>
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
                                {{ $upisnik->slovo }} - {{ $upisnik->naziv }}</option>
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
        <div class="form-group{{ $errors->has('vrsta_predmeta_id') ? ' has-error' : '' }}">
            <label for="vrsta_predmeta_id">Врста предмета:</label>
            <select name="vrsta_predmeta_id" id="vrsta_predmeta_id" class="chosen-select form-control" data-placeholder="Врста предмета" required>
                <option value=""></option>
                @foreach($vrste as $vrsta)
                <option value="{{ $vrsta->id }}"{{ old('vrsta_predmeta_id') == $vrsta->id ? ' selected' : '' }}>
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
        <div class="form-group{{ $errors->has('referent_id') ? ' has-error' : '' }}">
            <label for="referent_id">Референт:</label>
            <select name="referent_id" id="referent_id" class="chosen-select form-control" data-placeholder="Референт" required>
                <option value=""></option>
                @foreach($referenti as $referent)
                <option value="{{ $referent->id }}"{{ old('referent_id') == $referent->id ? ' selected' : '' }}>
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
</div>
    {{-- Red sa sudom --}}
    <fieldset>
    <legend>Надлежни орган</legend>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('sud_id') ? ' has-error' : '' }}">
                <label for="sud_id">Надлежни орган:</label>
                <select name="sud_id" id="sud_id" class="chosen-select form-control" data-placeholder="Надлежни орган" required>
                    <option value=""></option>
                    @foreach($sudovi as $sud)
                    <option value="{{ $sud->id }}"{{ old('sud_id') == $sud->id ? ' selected' : '' }}>
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
        <div class="form-group{{ $errors->has('datum_tuzbe') ? ' has-error' : '' }}">
            <label for="datum_tuzbe">Датум предмета (тужбе):</label>
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
</fieldset>

<div class="form-group text-right">
    <button type="submit" class="btn btn-success" id="dugmeDodaj"><i class="fa fa-plus-circle"></i> Додај</button>
    <a class="btn btn-danger" href="{{route('predmeti')}}"><i class="fa fa-ban"></i> Откажи</a>
</div>
</form>

@endsection

@section('traka')

@endsection
@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>

<script>

$(document).ready(function () {
var submit = false;
jQuery(window).on('resize', resizeChosen);
$('.chosen-select').chosen({
allow_single_deselect: true
});
function resizeChosen() {
$(".chosen-container").each(function () {
$(this).attr('style', 'width: 100%');
});
}
function promeniBrojPredmeta(){
var upisnik = $("#vrsta_upisnika_id").val();
var godina = $("#godina_predmeta").val();
var ruta = "{{ route('predmeti.broj') }}";
$.ajax({
type : 'get',
        url : ruta,
        data : {"upisnik":upisnik, "godina":godina},
        success:function(broj){
        $('#broj_predmeta').val(broj);
        if (submit){
        $("#forma-dodavanje").submit();
        }
        }
});
}
$("#vrsta_upisnika_id").on('change', function () {
promeniBrojPredmeta();
});
$("#godina_predmeta").on('change', function () {
promeniBrojPredmeta();
});
$("#dugmeDodaj").on('click', function (e) {
e.preventDefault();
submit = true;
promeniBrojPredmeta();
});
});
</script>
@endsection
