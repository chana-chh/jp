@extends('sabloni.app')

@section('naziv', 'Референти | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Преглед и измена детаља референата</h1>

    <div class="well">
    <form action="{{ route('referenti.izmena',  $referent->id) }}" method="POST">
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-6">
        <div class="form-group{{ $errors->has('ime') ? ' has-error' : '' }}">
            <label for="ime">Име: </label>
            <input type="text" name="ime" id="ime" class="form-control" value="{{ old('ime', $referent->ime) }}" required>
            @if ($errors->has('ime'))
                <span class="help-block">
                    <strong>{{ $errors->first('ime') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-6">
        <div class="form-group{{ $errors->has('prezime') ? ' has-error' : '' }}">
            <label for="prezime">Презиме: </label>
            <input type="text" name="prezime" id="prezime" class="form-control" value="{{ old('prezime', $referent->prezime) }}">
            @if ($errors->has('prezime'))
                <span class="help-block">
                    <strong>{{ $errors->first('prezime') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-6">
        <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
            <label for="napomena">Напомена: </label>
            <input type="text" name="napomena" id="napomena" class="form-control" value="{{ old('napomena', $referent->napomena) }}">
            @if ($errors->has('napomena'))
                <span class="help-block">
                    <strong>{{ $errors->first('napomena') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>

        <div class="form-group text-right" style="margin-top: 20px">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Измени</button>
            <a class="btn btn-danger" href="{{route('referenti')}}"><i class="fa fa-ban"></i> Откажи измене</a>
        </div>
    </form>
</div>
@endsection