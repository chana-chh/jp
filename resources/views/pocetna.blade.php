@extends('sabloni.app')

@section('naziv', 'Почетна')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Почетна страна</h1>

    <div class="row" style="margin: 20px; padding: 10px">
<div class="col-md-3">
  <a href="{{ route('predmeti') }}">
  <img class="grow center-block" alt="predmeti" src="{{url('/images/predmeti.png')}}" style="height:128px;">
  </a>
</div> 
<div class="col-md-3">
  <a href="#">
  <img class="grow center-block" alt="kalendar" src="{{url('/images/kalendar.png')}}" style="height:128px;">
  </a>
</div>  
<div class="col-md-3">
  <a href="{{ route('rocista') }}">
  <img class="grow center-block" alt="rokovi" src="{{url('/images/rokovi.png')}}" style="height:128px;">
  </a>
</div>  
<div class="col-md-3">
  <a href="#">
  <img  class="grow center-block" alt="novac" src="{{url('/images/novac.png')}}" style="height:128px;">
  </a>
</div>  
</div>

<h2>Поднаслов, оуу јеее</h2>

@if (Gate::allows('admin'))
  <p style="color: red;">Ово види само админ. {{$pravo}}</p>
  @endif
@endsection