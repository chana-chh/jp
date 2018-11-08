@extends('sabloni.app')

@section('naziv', 'Коминтенти | Преглед')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1>Преглед и измена детаља коминтента        </h1>
    </div>
</div>
<hr>

<div class="row" style="margin-bottom: 16px; margin-top: 16px">
    <div class="col-md-10 col-md-offset-1">
        <div class="btn-group">
            <a class="btn btn-primary" onclick="window.history.back();"
               title="Повратак на претходну страну">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a class="btn btn-primary" href="{{ route('pocetna') }}"
               title="Повратак на почетну страну">
                <i class="fa fa-home"></i>
            </a>
            <a class="btn btn-primary" href="{{ route('komintenti') }}"
               title="Повратак на листу коминтената">
                <i class="fa fa-list"></i>
            </a>
        </div>
    </div>
</div>
<div class="row ceo_dva">
    <div class="col-md-10 col-md-offset-1 boxic">

        <form action="{{ route('komintenti.izmena',  $komintent->id) }}" method="POST" data-parsley-validate style="margin-top: 2rem;">
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
                        <label for="naziv">Назив коминтена:</label>
                        <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv', $komintent->naziv) }}" maxlength="190" required>
                        @if ($errors->has('naziv'))
                        <span class="help-block">
                            <strong>{{ $errors->first('naziv') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('id_broj') ? ' has-error' : '' }}">
                        <label for="id_broj">Матични број:</label>
                        <input type="text" name="id_broj" id="id_broj" class="form-control" value="{{ old('id_broj', $komintent->id_broj) }}" maxlength="20" required>
                        @if ($errors->has('id_broj'))
                        <span class="help-block">
                            <strong>{{ $errors->first('id_broj') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group{{ $errors->has('adresa') ? ' has-error' : '' }}">
                        <label for="adresa">Адреса:</label>
                        <input type="text" name="adresa" id="adresa" class="form-control" value="{{ old('adresa', $komintent->adresa) }}" maxlength="255">
                        @if ($errors->has('adresa'))
                        <span class="help-block">
                            <strong>{{ $errors->first('adresa') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('mesto') ? ' has-error' : '' }}">
                        <label for="mesto">Место:</label>
                        <input type="text" name="mesto" id="mesto" class="form-control" value="{{ old('mesto', $komintent->mesto) }}" maxlength="100">
                        @if ($errors->has('mesto'))
                        <span class="help-block">
                            <strong>{{ $errors->first('mesto') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">

            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
                        <label for="napomena">Напомена:</label>
                        <textarea name="napomena" id="napomena" maxlength="255" class="form-control">{{ old('napomena', $komintent->napomena) }}</textarea>
                        @if ($errors->has('napomena'))
                        <span class="help-block">
                            <strong>{{ $errors->first('napomena') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group{{ $errors->has('telefon') ? ' has-error' : '' }}">
                        <label for="telefon">Телефон:</label>
                        <input type="text" name="telefon" id="telefon" class="form-control" value="{{ old('telefon', $komintent->telefon) }}" maxlength="100">
                        @if ($errors->has('telefon'))
                        <span class="help-block">
                            <strong>{{ $errors->first('telefon') }}</strong>
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
                            <a class="btn btn-danger btn-block" href="{{route('komintenti')}}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('skripte')
<script>
    $(document).ready(function () {
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
