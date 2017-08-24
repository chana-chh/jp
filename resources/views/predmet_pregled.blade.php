@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
        &emsp; Преглед предмета број
        <span class="{{ $predmet->arhiviran == 0 ? 'text-success' : 'text-danger' }}">
            {{ $predmet->vrstaUpisnika->slovo }} {{ $predmet->broj_predmeta }}/{{ $predmet->godina_predmeta }}
            {{ $predmet->arhiviran == 0 ? '' : ' - (а/а)' }}
        </span>
    </h1>
@endsection

@section('sadrzaj')
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Датум:</div>
        <div class="col-md-9">{{ date('d.m.Y', strtotime($predmet->datum_tuzbe)) }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Суд:</div>
        <div class="col-md-9">{{ $predmet->sud->naziv }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Врста предмета:</div>
        <div class="col-md-9">{{ $predmet->vrstaPredmeta->naziv }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Катастарска парцела:</div>
        <div class="col-md-9">{{ $predmet->opis_kp }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Адреса:</div>
        <div class="col-md-9">{{ $predmet->opis_adresa }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Опис предмета:</div>
        <div class="col-md-9">{{ $predmet->opis }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Странка 1:</div>
        <div class="col-md-9">{{ $predmet->stranka_1 }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Странка 2:</div>
        <div class="col-md-9">{{ $predmet->stranka_2 }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Вредност тужбе:</div>
        <div class="col-md-9">{{ $predmet->vrednost_tuzbe }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Референт:</div>
        <div class="col-md-9">{{ $predmet->referent->ime }} {{ $predmet->referent->prezime }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Предмет родитељ:</div>
        <div class="col-md-9">
        @if($predmet->roditelj)
            {{ $predmet->roditelj->vrstaUpisnika->slovo }}
            {{ $predmet->roditelj->broj_predmeta }}/{{ $predmet->roditelj->godina_predmeta }}
        @endif
        </div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Напомена:</div>
        <div class="col-md-9">{{ $predmet->napomena }}</div>
    </div>
@endsection

@section('traka')
<div class="well bullets">
    <h3 style="margin-bottom: 20px">Рочишта</h3>
    <hr style="border-top: 1px solid #18BC9C">
    <ul>
    @foreach ($predmet->rocista as $rociste)
        <li>
            <span class="text-success">{{ $rociste->tipRocista->naziv }}</span> дана {{ date('d.m.Y', strtotime($rociste->datum)) }} у {{ date('H:i', strtotime($rociste->vreme)) }} часова.<br>
            <i>{{ $rociste->opis }}</i>
        </li>
    @endforeach
    </ul>
    <hr>
    <div class="row">
    <button style="float: right; margin-right: 10px" class="btn btn-success btn-sm otvori_dodavanje_rocista" id="dugmeDodajRociste" data-toggle="modal" data-target="#dodajModal" value="{{$predmet->id}}"><i class="fa fa-plus"></i></button>
    </div>
</div>
<div class="well">
    <h3>Токови</h3>
    <hr style="border-top: 1px solid #18BC9C">
    @foreach ($predmet->tokovi as $tok)
        {{ date('d.m.Y', strtotime($tok->datum)) }} -
        {{ $tok->status->naziv }} ({{ $tok->opis }})<br>
        Вредност спора потражује: {{ $tok->vrednost_spora_potrazuje }}<br>
        Вредност спора дугује: {{ $tok->vrednost_spora_duguje }}<br>
        Износ трошкова потражује: {{ $tok->iznos_troskova_potrazuje }}<br>
        Износ трошкова дугује: {{ $tok->iznos_troskova_duguje }}<br>
    @endforeach
</div>
<div class="well">
    <h3>Управе</h3>
    <hr style="border-top: 1px solid #18BC9C">
    @foreach ($predmet->uprave as $uprava)
    <p>
        {{ $uprava->sifra }} - {{ $uprava->naziv }}
        {{ $uprava->napomena }}
    </p>
    @endforeach
</div>
{{-- Pocetak Modala za dijalog dodavanje--}}
    <div class="modal fade" id="dodajModal" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-primary">Додај рочиште</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('rocista.dodavanje.post') }}" method="POST">
              {{ csrf_field() }}

            <div class="row">
                <div class="col-md-4">
        <div class="form-group{{ $errors->has('datum') ? ' has-error' : '' }}">
            <label for="datum">Датум: </label>
            <input type="date" name="datum" id="datum" class="form-control" value="{{ old('datum') }}">
            @if ($errors->has('datum'))
                <span class="help-block">
                    <strong>{{ $errors->first('datum') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-4">
         <div class="form-group{{ $errors->has('vreme') ? ' has-error' : '' }}">
            <label for="vreme">Време: </label>
            <input type="time" name="vreme" id="vreme" class="form-control" value="{{ old('vreme') }}">
            @if ($errors->has('vreme'))
                <span class="help-block">
                    <strong>{{ $errors->first('vreme') }}</strong>
                </span>
            @endif
        </div>
        </div>

         <div class="col-md-4">
         <div class="form-group{{ $errors->has('tip_id') ? ' has-error' : '' }}">
                    <label for="tip_id">Типови рочишта:</label>
                    <select name="tip_id" id="tip_id" class="chosen-select form-control" data-placeholder="Тип рочишта" >
                    <option value=""></option>
                    @foreach($tipovi_rocista as $tip)
                    <option value="{{ $tip->id }}"{{ old('tip_id') == $tip->id ? ' selected' : '' }}><strong>{{ $tip->naziv }}</strong></option>
                    @endforeach
                    </select>
                        @if ($errors->has('tip_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tip_id') }}</strong>
                        </span>
                        @endif
                </div>
        </div>
        </div>
        <hr style="border-top: 2px solid #18BC9C">
        <div class="row">
        <div class="col-md-12">
        <div class="form-group{{ $errors->has('opis') ? ' has-error' : '' }}">
            <label for="opis">Опис: </label>
            <TEXTAREA name="opis" id="opis" class="form-control" rows="3">{{old('opis') }}</TEXTAREA>
            @if ($errors->has('opis'))
                <span class="help-block">
                    <strong>{{ $errors->first('opis') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>


              <button type="submit" class="btn btn-success">Додај</button>
              <input type="hidden" id="predmet_id" name="predmet_id" value="{{$predmet->id}}">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Откажи</button>
          </div>

        </div>

      </div>
    </div>
    {{-- Kraj Modala za dijalog dodavanje--}}
@endsection

 @section('skripte')
<script>
$( document ).ready(function() {
    $('#dodajModal').on('shown.bs.modal', function () {
  $('.chosen-select', this).chosen({allow_single_deselect: true});});
});
</script>
@endsection 