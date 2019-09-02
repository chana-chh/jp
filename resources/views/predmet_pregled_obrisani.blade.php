@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-12">
        <h1>
            <img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:50px;">
            Преглед предмета број
            <span class="text-danger">
                {{ $predmet->broj() }}
            </span>
        </h1>
    </div>
</div>
<hr>
@endsection

@section('sadrzaj')
<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-md-2">
            <a class="btn btn-primary btn-block ono" onclick="window.history.back();" style="margin-top: 5px"
               title="Повратак на претходну страну">
                <i class="fa fa-arrow-left"></i>
            </a>
        </div>
            <div class="col-md-2">
                <a href="{{ route('predmeti') }}" class="btn btn-primary btn-block ono" style="margin-top: 5px">
                    <i class="fa fa-arrow-circle-left"></i> На предмете
                </a>
            </div>
            <div class="col-md-8">
                <h3 class="text-danger">Овај предмет је обрисан: {{$predmet->deleted_at}}</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@section('traka')
@if (Gate::allows('admin'))
<div class="panel panel-info">
    <div class="panel-heading">
        <h5>Мета информације о предмету</h4>
    </div>
    <div class="panel-body" style="font-size: 0.938em">
        <p>
            Последњу измену је извршио
            <strong class="text-primary">{{ $predmet->korisnik->name }}</strong>
        </p>
        <p>
            Предмет је додат у базу
            <strong class="text-primary">{{ date('d.m.Y', strtotime($predmet->created_at)) }}</strong>
        </p>
        <p>
            Предмет је последњи пут измењен
            <strong class="text-primary">{{ date('d.m.Y', strtotime($predmet->updated_at)) }}</strong>
        </p>
    </div>
</div>
@endif
@endsection