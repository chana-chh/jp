@extends('sabloni.app')

@section('naziv', 'Рочишта')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-6">
        <h1>
            <img class="slicica_animirana" alt="рочиште" src="{{url('/images/rokovi.png')}}" style="height:64px">
            &emsp;Табеларни преглед рочишта <small class="text-danger"><em>(филтрирани)</em></small>
        </h1>
    </div>

    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('rocista') }}">
            <i class="fa fa-minus-circle fa-fw"></i> Уклони филтер
        </a>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
                <button class="btn btn-warning btn-block ono" onClick="window.print()">
                    <i class="fa fa-print"></i> Штампај
                </button>
            </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-success btn-block ono" href="{{ route('rocista.kalendar') }}" ><i class="fa fa-arrow-circle-left"></i> Назад на календарски приказ</a>
    </div>
</div>
<hr style="border-top: 1px solid #18BC9C">

@if($rocista->isEmpty())
<h3 class="text-danger">Нема записа у бази података</h3>
@else
@if($ref)
<h3>{{$ref->imePrezime()}}</h3>
@endif
<hr>
@foreach ($datumi as $dat)
    <h3>{{Carbon\Carbon::parse($dat)->format('d.m.Y')}}</h3>
    <hr style="border-top: 1px dotted #18BC9C">
    <table class="table table-bordered table-hover tabelaRocista" name="tabelaRocista" id="tabelaRocista" style="table-layout: fixed; font-size: 1.3em">
    <thead>
        <tr>
            <th style="width: 16%; text-align:right; padding-right: 25px">Број предмета</th>
            <th style="width: 14%; text-align:right; padding-right: 25px">Датум</th>
            <th style="width: 10%; text-align:right; padding-right: 25px">Време</th>
            <th style="width: 30%; text-align:right; padding-right: 25px">Опис</th>
            <th style="width: 30%; text-align:right; padding-right: 25px">Белешке</th>
        </tr>
    </thead>
    <tbody id="rocista_lista" name="rocista_lista">
        @foreach ($rocista->where('datum', $dat)->sortBy('vreme') as $rociste)
        <tr>
            <td style="text-align:right"><strong>
                    <a href="{{ route('predmeti.pregled', $rociste->id) }}">
                        {{ $rociste->slovo }}-{{ $rociste->broj }}/{{ $rociste->godina }}
                    </a>
                </strong></td>
            <td style="text-align:right"><strong style="color: #18BC9C;">{{ Carbon\Carbon::parse($rociste->datum)->format('d.m.Y') }}</strong></td>
            <td style="text-align:right">{{$rociste->vreme ? date('H:i', strtotime($rociste->vreme)) : ''}}</td>
            <td style="text-align:right">
                @if($rociste->zamena != null)
					
                @foreach($referenti->where('id', $rociste->zamena) as $referentzam)
                <small>{{$referentzam->imePrezime()}}</small>
                @endforeach
				<small> мења {{$rociste->ime_referenta}} {{$rociste->prezime_referenta}}</small>																					
                @endif
                <em>{{$rociste->opis}}</em></td>
            <td >

            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endforeach

@endif
@endsection

@section('skripte')

@endsection
