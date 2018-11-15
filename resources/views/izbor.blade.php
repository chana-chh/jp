@extends('sabloni.app')

@section('naziv', 'Рокови/рочишта - избор')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header" style="text-align: center">РОКОВИ / РОЧИШТА - избор</h1>
<div class="row">
    <div class="col-md-5">
        <h1>
        <img class="img-responsive center-block" alt="Рокови" style="height:256px;"
        src="{{url('/images/rok.png')}}">
        </h1>
        <hr>
        <h2 class="text-center">
        <a href="{{ route('rokovi.kalendar') }}">Рокови</a>
        </h2>
    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-5">
        <h1>
        <img  class="img-responsive center-block" alt="Рочишта" style="height:256px; text-align: center"
        src="{{url('/images/rociste.png')}}">
        </h1>
        <hr>
        <h2 class="text-center">
        <a href="{{ route('rocista.kalendar') }}">Рочишта</a>
        </h2>
    </div>
</div>
@endsection