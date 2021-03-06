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
@endsection
@section('sadrzaj')
<form action="{{ route('predmeti.dodavanje.post') }}" method="POST" id="forma-dodavanje" data-parsley-validate>
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
                <option value="{{ $referent->id }}"{{ old('referent_id') == $referent->id ? ' selected' : '' }} data-referent="{{url('/audio/'.$referent->audio)}}">
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
               value="{{ old('vrednost_tuzbe') ? old('vrednost_tuzbe') : 10000 }}">
        @if ($errors->has('vrednost_tuzbe'))
        <span class="help-block">
            <strong>{{ $errors->first('vrednost_tuzbe') }}</strong>
        </span>
        @endif
    </div>
</div>
</div>
    <fieldset>
    <legend>Странке</legend>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('komintenti_1') ? ' has-error' : '' }}">
                <label for="komintenti_1">Прва странка (тужилац):</label>
                <select name="komintenti_1[]" id="komintenti_1" class="chosen-select form-control"
                        data-placeholder="Прва странка" multiple>
                    @foreach($komintenti as $kom1)
                    <option value="{{ $kom1->id }}"{{ collect(old('komintenti_1'))->contains($kom1->id) ? ' selected' : '' }}>
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
                    <option value="{{ $kom2->id }}"{{ collect(old('komintenti_2'))->contains($kom2->id) ? ' selected' : '' }}>
                            {{ $kom2->naziv }} - {{ $kom2->id_broj }}</option>
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
            <div class="form-group{{ $errors->has('bno') ? ' has-error' : '' }}">
                <label for="bno">Број код надлежног органа:</label>
                <input type="text" name="bno" id="bno" class="form-control">{{ old('bno') }}</input>
                @if ($errors->has('bno'))
                <span class="help-block">
                    <strong>{{ $errors->first('bno') }}</strong>
                </span>
                @endif
            </div>
            <p><small class="text-warning">*Напомена: у случају да има више бројева додати их након креирања предмета са детаљног прегледа</small></p>
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
 <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('sudnica') ? ' has-error' : '' }}">
                <label for="sudnica">Судница:</label>
                <input type="text" name="sudnica" id="sudnica" class="form-control">{{ old('sudnica') }}</input>
                @if ($errors->has('sudnica'))
                <span class="help-block">
                    <strong>{{ $errors->first('sudnica') }}</strong>
                </span>
                @endif
            </div>
        </div>
         <div class="col-md-4">
            <div class="form-group{{ $errors->has('sudija') ? ' has-error' : '' }}">
                <label for="sudija">Судија:</label>
                <input type="text" name="sudija" id="sudija" class="form-control">{{ old('sudija') }}</input>
                @if ($errors->has('sudija'))
                <span class="help-block">
                    <strong>{{ $errors->first('sudija') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('advokat') ? ' has-error' : '' }}">
                <label for="advokat">Адвокат:</label>
                <input type="text" name="advokat" id="advokat" class="form-control">{{ old('advokat') }}</input>
                @if ($errors->has('advokat'))
                <span class="help-block">
                    <strong>{{ $errors->first('advokat') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col-md-4">
            <div class="form-group{{ $errors->has('izvrsitelj') ? ' has-error' : '' }}">
                <label for="izvrsitelj">Извршитељ:</label>
                <input type="text" name="izvrsitelj" id="izvrsitelj" class="form-control">{{ old('izvrsitelj') }}</input>
                @if ($errors->has('izvrsitelj'))
                <span class="help-block">
                    <strong>{{ $errors->first('izvrsitelj') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    </fieldset>

    {{-- Red sa statusom/tokom --}}
    <fieldset>
    <legend>Подаци за први иницијални статус у токовима</legend>
    <p><small class="text-warning">*Напомена: у случају да се не одабере статус иницијални запис неће бити креиран!</small></p>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label for="status">Статус</label>
                                <select name="status" id="status" class="chosen-select form-control"
                                        data-placeholder="Статус">
                                    <option value=""></option>
                                    @foreach($statusi as $status)
                                    <option value="{{ $status->id }}"{{ old('status') == $status->id ? ' selected' : '' }}>
                                            {{ $status->naziv }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('status'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('vrednost') ? ' has-error' : '' }}">
                            <label for="vrednost">Вредност тужбе ће бити уписана у поље</label>
                    <select name="vrednost" id="vrednost" class="chosen-select form-control"
                                        data-placeholder="Избор поља за упис вредности">
                        <option value=""></option>
                        <option value="1">Град дугује</option>
                        <option value="2">Град потражује</option>
                    </select>
                        @if ($errors->has('vrednost'))
                            <span class="help-block">
                                <strong>{{ $errors->first('vrednost') }}</strong>
                            </span>
                        @endif
                        </div>
                    </div>     
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('status_opis') ? ' has-error' : '' }}">
                            <label for="status_opis">Опис статуса токова</label>
                            <textarea name="status_opis" id="status_opis" class="form-control">{{ old('status_opis') }}</textarea>
                            @if ($errors->has('status_opis'))
                            <span class="help-block">
                                <strong>{{ $errors->first('status_opis') }}</strong>
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
                       value="{{ old('opis_kp') }}" maxlength="255">
                @if ($errors->has('opis_kp'))
                <span class="help-block">
                    <strong>{{ $errors->first('opis_kp') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('opis_adresa') ? ' has-error' : '' }}">
                <label for="opis_adresa">Улица:</label>
                <input type="text" name="opis_adresa" id="opis_adresa" class="form-control"
                       value="{{ old('opis_adresa') }}" maxlength="255">
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
                <textarea name="opis" id="opis" class="form-control">{{ old('opis') }}</textarea>
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
{{-- <div class="row">
<div class="col-md-6">
    <div class="form-group{{ $errors->has('roditelj_id') ? ' has-error' : '' }}">
        <label for="roditelj_id">Предмет родитељ:</label>
        <select name="roditelj_id" id="roditelj_id" class="chosen-select form-control" data-placeholder="Предмет родитељ">
            <option value=""></option>
            @foreach($predmeti as $predmet)
            <option value="{{ $predmet->idp }}"{{ old('roditelj_id') == $predmet->idp ? ' selected' : '' }}>
                    {{ $predmet->ceo_broj_predmeta }}
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
            <textarea name="napomena" id="napomena" class="form-control">{{ old('napomena') }}</textarea>
            @if ($errors->has('napomena'))
            <span class="help-block">
                <strong>{{ $errors->first('napomena') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div> --}}
<div class="form-group text-right">
    <button type="submit" class="btn btn-success" id="dugmeDodaj"><i class="fa fa-plus-circle"></i> Додај</button>
    <a class="btn btn-danger" href="{{route('predmeti')}}"><i class="fa fa-ban"></i> Откажи</a>
</div>
</form>

@endsection

@section('traka')
<audio id="audio1" type="audio/mpeg"></audio>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Провера катастарска парцела</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped" style="font-size: 0.75em;">
            <thead>
                <tr>
                    <th style="width: 15%">Број </th>
                    <th style="width: 35%">Опис </th>
                    <th style="width: 25%">Врста </th>
                    <th style="width: 25%">КП</th>
                </tr>
            </thead>
            <tbody id="kp_body">
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>

<script>
$(document).ready(function () {

$("#referent_id").on("change",function(){
  putanja=$( "#referent_id option:selected" ).data('referent');
  audio=$("#audio1");
  $("#audio1").attr("src",putanja);

  audio[0].pause();
  audio[0].load();
  audio[0].play();
});
var submit = false;
$('#stranka_1').on('keyup', function () {
$vrednost = $(this).val();
$.ajax({
type : 'get',
        url : '{{URL::to('proveraTuzilac')}}',
        data : {'proveraTuzilac':$vrednost},
        success:function(data){
        $('#tuzilac_body').html(data);
        $('.popTuzilac').popover({
        trigger: 'hover'
        });
        }
});
});
$('#opis_kp').on('keyup', function () {
$vrednost = $(this).val();
$.ajax({
type : 'get',
        url : '{{URL::to('proveraKp')}}',
        data : {'proveraKp':$vrednost},
        success:function(data){
        $('#kp_body').html(data);
        $('.popKp').popover({
        trigger: 'hover'
        });
        }
});
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
