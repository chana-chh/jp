@extends('sabloni.app')

@section('naziv', 'Референти | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row ceo_dva">
    <div class="col-md-10 col-md-offset-1 boxic">
    <h1 class="page-header">Преглед и измена детаља референата</h1>

    <div class="well">
    <form action="{{ route('referenti.izmena',  $referent->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-6">
        <div class="form-group{{ $errors->has('ime') ? ' has-error' : '' }}">
            <label for="ime">Име: </label>
            <input type="text" name="ime" id="ime" maxlength="100" class="form-control" value="{{ old('ime', $referent->ime) }}" required>
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
            <input type="text" name="prezime" id="prezime" maxlength="150" class="form-control" value="{{ old('prezime', $referent->prezime) }}" required>
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
                    <label for="napomena">Напомена:</label>
                    <textarea name="napomena" id="napomena" maxlength="255" class="form-control">{{ old('napomena', $referent->napomena) }}</textarea>
                    @if ($errors->has('napomena'))
                        <span class="help-block">
                            <strong>{{ $errors->first('napomena') }}</strong>
                        </span>
                    @endif
                </div>
        </div>
        </div>

        <div class="row dugmici">
        <div class="col-md-6 col-md-offset-6">
        <div class="form-group text-right ceo_dva">
        <div class="col-md-6 snimi">
            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-floppy-o"></i>&emsp;Сними</button>
        </div>
        <div class="col-md-6">
            <a class="btn btn-danger btn-block" href="{{route('referenti')}}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
        </div>
        </div>
        </div>
        </div>
    </form>
</div>
</div>
</div>
@endsection

@section('skripte')
<script>
    $( document ).ready(function() {
        $('textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
            }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection