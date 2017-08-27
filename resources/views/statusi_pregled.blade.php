@extends('sabloni.app')

@section('naziv', 'Статуси | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Преглед и измена детаља статуса</h1>

    <div class="well">
    <form action="{{ route('statusi.izmena',  $status->id) }}" method="POST">
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-6">
        <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
            <label for="naziv">Назив статуса: </label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv', $status->naziv) }}" required>
            @if ($errors->has('naziv'))
                <span class="help-block">
                    <strong>{{ $errors->first('naziv') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-6">
        <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
            <label for="napomena">Напомена: </label>
            <input type="text" name="napomena" id="napomena" class="form-control" value="{{ old('napomena', $status->napomena) }}">
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
            <a class="btn btn-danger" href="{{route('statusi')}}"><i class="fa fa-ban"></i> Откажи измене</a>
        </div>
    </form>
</div>
@endsection