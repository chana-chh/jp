@extends('sabloni.app')

@section('naziv', 'Градске управе | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1><img class="slicica_animirana" alt="Врсте уписника"
                 src="{{url('/images/uprava.png')}}" style="height:64px;">
            &emsp;Преглед и измена детаља назива Градске управе
        </h1>
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
            <a class="btn btn-primary" href="{{ route('uprave') }}"
               title="Повратак на листу управа">
                <i class="fa fa-list"></i>
            </a>
        </div>
    </div>
</div>
    <div class="row ceo_dva">
    <div class="col-md-10 col-md-offset-1 boxic">

    <form action="{{ route('uprave.izmena',  $uprava->id) }}" method="POST" data-parsley-validate style="margin-top: 2rem;">
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-4">
        <div class="form-group{{ $errors->has('sifra') ? ' has-error' : '' }}">
            <label for="sifra">Шифра управе (директног корисника): </label>
            <input type="text" name="sifra" id="sifra" class="form-control" value="{{ old('sifra', $uprava->sifra) }}" maxlength="20" required>
            @if ($errors->has('sifra'))
                <span class="help-block">
                    <strong>{{ $errors->first('sifra') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-8">
       <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
                    <label for="naziv">Назив управе:</label>
                     <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv', $uprava->naziv) }}" maxlength="190" required>
                    @if ($errors->has('naziv'))
                        <span class="help-block">
                            <strong>{{ $errors->first('naziv') }}</strong>
                        </span>
                    @endif
                </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-8 col-md-offset-4">
       <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
                    <label for="napomena">Напомена:</label>
                    <textarea name="napomena" id="napomena" maxlength="255" class="form-control">{{ old('napomena', $uprava->napomena) }}</textarea>
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
            <a class="btn btn-danger btn-block" href="{{route('uprave')}}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
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