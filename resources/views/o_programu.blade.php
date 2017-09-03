@extends('sabloni.app')

@section('naziv', 'О програму')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header">О програму</h1>
<p>Знам да ће ово бити најтежи део посла</p>
<div class="row">
<div class="col-md-10 col-md-offset-1 boxic">
<img src="{{url('/images/giljotina.png')}}" alt="..." class="img-circle">
</div>
</div>
@endsection
