@extends('sabloni.app')

@section('naziv', 'Врсте предмета | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <h1><img class="slicica_animirana" alt="Врсте предмета"
                 src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Преглед и измена детаља врсте предмета
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
            <a class="btn btn-primary" href="{{ route('vrste_predmeta') }}"
               title="Повратак на листу врсте предмета">
                <i class="fa fa-list"></i>
            </a>
        </div>
    </div>
</div>
    <div class="row ceo_dva">
    <div class="col-md-10 col-md-offset-1 boxic">

    <form action="{{ route('vrste_predmeta.izmena',  $vrsta_predmeta->id) }}" method="POST" data-parsley-validate style="margin-bottom: 16px; margin-top: 16px">
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-5">
        <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
            <label for="naziv">Врста предмета (назив): </label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv', $vrsta_predmeta->naziv) }}" required>
            @if ($errors->has('naziv'))
                <span class="help-block">
                    <strong>{{ $errors->first('naziv') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-7">
        <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
                    <label for="napomena">Напомена:</label>
                    <textarea name="napomena" id="napomena" maxlength="255" class="form-control">{{ old('napomena', $vrsta_predmeta->napomena) }}</textarea>
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
            <a class="btn btn-danger btn-block" href="{{route('vrste_predmeta')}}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
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