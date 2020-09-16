@extends('sabloni.app')

@section('naziv', 'Промена референта у предметима')

@section('meni')
    @include('sabloni.inc.meni')
@endsection



@section('naslov')
<div class="row">
    <div class="col-md-9">
    <h1><img class="slicica_animirana" alt="Референти"
                 src="{{url('/images/referent.png')}}" style="height:64px;">
            &emsp;Промена референта у предметима
        </h1>
    </div>
        <div class="col-md-3 text-right" style="padding-top: 50px;">
        <a href="{{ route('referenti.vracanje') }}" id="pretragaDugme" class="btn btn-success btn-block ono">
            <i class="fa fa-eye fa-fw"></i> Преглед досада пребачених предмета
        </a>
    </div>
</div>
<hr>
        <h2 class="text-danger">Ова акција је неповратна!</h2>
<div class="well">
    <form action="{{ route('referenti.refpromena') }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}
        <div class="row" style="margin-top: 30px">
            <div class="form-group col-md-3">
                <label for="arhiviran">Архива</label>
                <select name="arhiviran" id="arhiviran" class="chosen-select form-control" data-placeholder="Архива">
                    <option value=""></option>
                    <option value="0">Активни</option>
                    <option value="1">Архивирани</option>
                </select>
            </div>
        <div class="col-md-2">
                <div class="form-group{{ $errors->has('broj_predmeta') ? ' has-error' : '' }}">
                    <label for="broj_predmeta">Последњи број предмета: </label>
                    <input type="number" name="broj_predmeta" id="broj_predmeta" class="form-control"
                           value="{{ old('broj_predmeta') }}" max="9">
                    @if ($errors->has('broj_predmeta'))
                    <span class="help-block">
                        <strong>{{ $errors->first('broj_predmeta') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
                        <div class="form-group col-md-3">
                <label for="vrsta_upisnika_id">Врста уписника</label>
                <select name="vrsta_upisnika_id" id="vrsta_upisnika_id" class="chosen-select form-control" data-placeholder="Врста уписника">
                    <option value=""></option>
                    @foreach($upisnici as $upisnik)
                    <option value="{{ $upisnik->id }}">
                        <strong>{{ $upisnik->naziv }}</strong>
                    </option>
                    @endforeach
                </select>
            </div>
                        <div class="form-group col-md-4">
                <label for="vrsta_predmeta_id">Врста предмета</label>
                <select name="vrsta_predmeta_id" id="vrsta_predmeta_id" class="chosen-select form-control" data-placeholder="Врста предмета">
                    <option value=""></option>
                    @foreach($vrste as $vrsta)
                    <option value="{{ $vrsta->id }}">
                        {{ $vrsta->naziv }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row" style="margin-top: 30px">
            <div class="col-md-6 col-md-offset-3">
        <div class="form-group{{ $errors->has('referent_uklanjanje') ? ' has-error' : '' }}">
            <label for="referent_uklanjanje">Референт чије СВЕ предмете желимо да предамо у надлежност другом референту:</label>
            <select name="referent_uklanjanje" id="referent_uklanjanje" class="chosen-select form-control" data-placeholder="Референт" required>
                <option value=""></option>
                @foreach($referenti as $referent)
                <option value="{{ $referent->id }}"{{ old('referent_uklanjanje') == $referent->id ? ' selected' : '' }}>
                        {{ $referent->ime }} {{ $referent->prezime }}
            </option>
            @endforeach
        </select>
        @if ($errors->has('referent_uklanjanje'))
        <span class="help-block">
            <strong>{{ $errors->first('referent_uklanjanje') }}</strong>
        </span>
        @endif
    </div>
</div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
        <h1><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></h1>
</div>
</div>
    <div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group{{ $errors->has('referent_dodavanje') ? ' has-error' : '' }}">
            <label for="referent_dodavanje">Референт коме се додају нови предмети:</label>
            <select name="referent_dodavanje" id="referent_dodavanje" class="chosen-select form-control" data-placeholder="Референт" required>
                <option value=""></option>
                @foreach($referenti as $referent)
                <option value="{{ $referent->id }}"{{ old('referent_dodavanje') == $referent->id ? ' selected' : '' }}>
                        {{ $referent->ime }} {{ $referent->prezime }}
            </option>
            @endforeach
        </select>
        @if ($errors->has('referent_dodavanje'))
        <span class="help-block">
            <strong>{{ $errors->first('referent_dodavanje') }}</strong>
        </span>
        @endif
    </div>
</div>
</div>
        <div class="row dugmici">
            <div class="col-md-6 col-md-offset-3" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-exchange"></i>&emsp;Промени референта у предметима
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{route('referenti.promena')}}">
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
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection
