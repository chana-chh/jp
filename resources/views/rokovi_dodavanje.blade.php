@extends('sabloni.app')

@section('naziv', 'Рокови')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/rokovi.png')}}" style="height:64px"></span>
        Додавање новог рока
    </h1>

   <form action="{{ route('rokovi.dodavanje.post') }}" method="POST" style="margin-top: 45px">
              {{ csrf_field() }}
        
            <div class="row">
            <div class="col-md-10 col-md-offset-1">
            
            <div class="form-group{{ $errors->has('predmet_id') ? ' has-error' : '' }}" style="margin-right: 15px; margin-left: 15px">
                    <label for="predmet_id">Предмет:</label>
                    <select name="predmet_id" id="predmet_id" class="chosen-select form-control" data-placeholder="Предмети" >
                    <option value=""></option>
                    @foreach($predmeti as $predmet)
                    <option value="{{ $predmet->id }}"{{ old('predmet_id') == $predmet->id ? ' selected' : '' }}><strong>
                                    {{$predmet->vrstaUpisnika->slovo}} {{$predmet->broj_predmeta}}/{{$predmet->godina_predmeta}}, &emsp; {{$predmet->vrstaPredmeta->naziv}}, &emsp; {{$predmet->opis_kp}}, {{$predmet->opis_adresa}}, {{$predmet->opis}}
                                </strong></option>
                    @endforeach
                    </select>
                        @if ($errors->has('predmet_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('predmet_id') }}</strong>
                        </span>
                        @endif
                </div>
                </div>
                </div>


            <div class="row" style="margin-top: 15px">
            <div class="col-md-10 col-md-offset-1">
            <div class="col-md-6">
        <div class="form-group{{ $errors->has('rok_dodavanje_datum') ? ' has-error' : '' }}">
            <label for="rok_dodavanje_datum">Датум: </label>
            <input type="date" name="rok_dodavanje_datum" id="rok_dodavanje_datum" class="form-control" value="{{ old('rok_dodavanje_datum') }}">
            @if ($errors->has('rok_dodavanje_datum'))
                <span class="help-block">
                    <strong>{{ $errors->first('rok_dodavanje_datum') }}</strong>
                </span>
            @endif
        </div>
        </div>


        </div>
        </div>
         <div class="row" style="margin-top: 15px">
        <div class="col-md-10 col-md-offset-1">
        <hr style="border-top: 2px solid #18BC9C">
        </div>
        </div>

        <div class="row" style="margin-top: 15px">
        <div class="col-md-10 col-md-offset-1">
        <div class="form-group{{ $errors->has('rok_dodavanje_opis') ? ' has-error' : '' }}">
            <label for="rok_dodavanje_opis">Опис: </label>
            <TEXTAREA name="rok_dodavanje_opis" id="rok_dodavanje_opis" class="form-control" rows="3">{{old('rok_dodavanje_opis') }}</TEXTAREA>
            @if ($errors->has('rok_dodavanje_opis'))
                <span class="help-block">
                    <strong>{{ $errors->first('rok_dodavanje_opis') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>

        <div class="row dugmici">
            <div class="col-md-4 col-md-offset-7" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-plus-circle"></i>&emsp;Додај
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{route('rokovi')}}">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
            </form>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {
    $('.chosen-select').chosen({allow_single_deselect: true, search_contains:true});
});
</script>
@endsection