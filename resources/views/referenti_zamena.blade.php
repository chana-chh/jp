@extends('sabloni.app')

@section('naziv', 'Референт на замени')

@section('meni')
    @include('sabloni.inc.meni')
@endsection



@section('naslov')
<div class="row">
    <div class="col-md-10">
    <h2><img class="slicica_animirana" alt="Референти"
                 src="{{url('/images/referent.png')}}" style="height:64px;">
            &emsp;Привремено постављање или уклањање референта задуженог за предмет <span class="text-success">
        {{ $predmet->broj() }} <small>Референт предмета је: {{$predmet->referent->imePrezime()}}</small>
    </span>
        </h2>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a href="{{ route('predmeti.pregled', $predmet->id) }}" class="btn btn-primary btn-block ono">
                    <i class="fa fa-arrow-circle-left"></i> Назад на предмет
                </a>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
        <strong class="text-info">{{ $rociste->tipRocista->naziv }} {{ date('d.m.Y', strtotime($rociste->datum)) }} {{ $rociste->vreme ? date('H:i', strtotime($rociste->vreme)) : '' }}</strong>
        @if(!$rociste->zamena)
        <h3><i class="fa fa-refresh" aria-hidden="true"></i> Тренутно нема заменског референта </h3>
        @else
        <h3 class="text-success"><i class="fa fa-refresh" aria-hidden="true"></i> Заменски референт је у овом тренутку {{$rociste->zamena->imePrezime()}}</h3>
        @endif
</div>
</div>
<div class="well">
    <form action="{{ route('referenti.zamena_add', $rociste->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}
        <div class="row" style="margin-top: 30px">
            <div class="col-md-6 col-md-offset-3">
        <div class="form-group{{ $errors->has('referent_zamena') ? ' has-error' : '' }}">
            <label for="referent_zamena">Избор референта :</label>
            <select name="referent_zamena" id="referent_zamena" class="chosen-select form-control" data-placeholder="Референт" required>
                <option value=""></option>
                @foreach($referenti as $referent)
                <option value="{{ $referent->id }}"{{ old('referent_zamena') == $referent->id ? ' selected' : '' }}>
                        {{ $referent->ime }} {{ $referent->prezime }}
            </option>
            @endforeach
        </select>
        @if ($errors->has('referent_zamena'))
        <span class="help-block">
            <strong>{{ $errors->first('referent_zamena') }}</strong>
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
                            <i class="fa fa-refresh"></i>&emsp;Постави замену
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-warning btn-block ono" href="{{route('referenti.zamena', $rociste->id)}}">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
</div>
<hr>
        <div class="row dugmici">
            <div class="col-md-4 col-md-offset-8" style="margin-top: 20px;">
                        <a class="btn btn-danger btn-block ono" href="{{route('referenti.zamena_del', $rociste->id)}}">
                            <i class="fa fa-trash-o"></i>&emsp;Уклањање привременог референта
                        </a>
            </div>
        </div>
@endsection

@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection
