@extends('sabloni.app')

@section('naziv', 'Поднесци предмета')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
       <h1><img class="slicica_animirana" alt="Поднесци предмета"
                 src="{{url('/images/ugovor.png')}}" style="height:64px;">
            &emsp;Поднесци предмета</h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a href="{{ route('predmeti.pregled', $predmet->id) }}" class="btn btn-primary btn-block ono">
                    <i class="fa fa-arrow-circle-left"></i> Назад на предмет
                </a>
    </div>
 
</div>
<div class="row">
    <div class="col-md-12">
   <hr>
</div>
</div>

@endsection

@section('sadrzaj')
@if($podnesci->count()>0)
<div class="row" style="margin-top: 5rem;">
    <div class="col-md-12">
<table class="table table-striped table-condensed table-responsive">
        <thead>
            <tr>
                <th style="width: 15%;">Датум подошења</th>
                <th style="width: 25%;">Подносиоц</th>
                <th style="width: 40%;">Опис</th>
                <th style="width: 15%;">Не знам</th>
            </tr>
        </thead>
        <tbody>
            @foreach($podnesci as $p)
            <tr>
                <td>{{ $p->datum_podnosenja }}</td>
                <td>{{ $p->podnosioc }}</td>
                <td>{{ $p->opis }}</td>
                <td>{{ $p->podnosioc_tip }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
@else
<h3 class="text-danger">За овај предмет нема поднесака</h3>
@endif

@endsection

@section('traka')
<h3 >Додавање новог поднеска</h3>
<hr>
<div class="well">
    <form action=" " method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('podnosioc') ? ' has-error' : '' }}">
            <label for="podnosioc">Подносиоци: </label>
            <input type="text" name="podnosioc" id="podnosioc" class="form-control" value="{{ old('podnosioc') }}" required>
            @if ($errors->has('podnosioc'))
                <span class="help-block">
                    <strong>{{ $errors->first('podnosioc') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('opis') ? ' has-error' : '' }}">
            <label for="opis">Опис: </label>
            <textarea name="opis" id="opis" maxlength="255" class="form-control">{{ old('opis') }}</textarea>
            @if ($errors->has('opis'))
                <span class="help-block">
                    <strong>{{ $errors->first('opis') }}</strong>
                </span>
            @endif
        </div>

        <div class="row dugmici">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-plus-circle"></i>&emsp;Додај
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href=" ">
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
<script>
$( document ).ready(function() {

    $(document).on('click', '.otvori-brisanje', function () {
        var id = $(this).val();
        $('#idBrisanje').val(id);
        /*
        var ruta = "";
        */
        $('#brisanje-forma').attr('action', ruta);
    });
});
</script>
@endsection