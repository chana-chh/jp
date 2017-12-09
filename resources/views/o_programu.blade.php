@extends('sabloni.app')

@section('naziv', 'О програму')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header">О програму</h1>
<p>Знам да ће ово бити најтежи део посла</p>
<div class="row">
<div class="col-md-12">
<img src="{{url('/images/gradnja.jpg')}}" alt="..." class="img-responsive center-block">
</div>
</div>
@endsection
