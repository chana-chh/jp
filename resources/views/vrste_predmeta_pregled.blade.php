@extends('sabloni.app')

@section('naziv', 'Врсте предмета | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')

    <div class="row ceo_dva">
    <div class="col-md-10 col-md-offset-1 boxic">
    <h1 class="page-header">Преглед и измена детаља врсте предмета</h1>

    <div class="well">
    <form action="{{ route('vrste_predmeta.izmena',  $vrsta_predmeta->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-4">
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

        <div class="col-md-8">
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