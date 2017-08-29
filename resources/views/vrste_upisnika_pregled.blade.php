@extends('sabloni.app')

@section('naziv', 'Врсте уписника | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Преглед и измена детаља врсте уписника</h1>

    <div class="well">
    <form action="{{ route('vrste_upisnika.izmena',  $vrsta_upisnika->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-4">
        <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
            <label for="naziv">Врста уписника (назив): </label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv', $vrsta_upisnika->naziv) }}" required>
            @if ($errors->has('naziv'))
                <span class="help-block">
                    <strong>{{ $errors->first('naziv') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-3">
                <div class="form-group{{ $errors->has('slovo') ? ' has-error' : '' }}">
            <label for="slovo">Акроним: </label>
            <input type="text" name="slovo" id="slovo" class="form-control" value="{{ old('slovo', $vrsta_upisnika->slovo) }}" required>
            @if ($errors->has('slovo'))
                <span class="help-block">
                    <strong>{{ $errors->first('slovo') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-5">
        <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
            <label for="napomena">Напомена: </label>
            <TEXTAREA name="napomena" id="napomena" class="form-control" rows="2">{{ old('napomena', $vrsta_upisnika->napomena) }}</TEXTAREA>
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
            <a class="btn btn-danger" href="{{route('vrste_upisnika')}}"><i class="fa fa-ban"></i> Откажи измене</a>
        </div>
    </form>
</div>
@endsection

@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection