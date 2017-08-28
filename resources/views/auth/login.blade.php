@extends('sabloni.app')

@section('naziv', 'Пријава')

@section('naslov')
<h1 class="page-header text-center">Јавно правобранилаштво Крагујевац</h1>
<div class="container">

    <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">

        <div class="row">
          <img src="{{url('/images/grb.jpg')}}" class="img-responsive" alt="grb">
        </div>

        <div class="panel panel-default" >
            <div class="panel-heading">
                <div class="panel-title text-center">Добродошли, молимо вас да се пријавите</div>
            </div>

            <div class="panel-body" >

                <form name="form" id="form" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('login') }}">
                   {{ csrf_field() }}
                    <div class="input-group log">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Корисничко име" required autofocus>
                    </div>

                    <div class="input-group log">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" placeholder="Лозинка" required>
                    </div>

                    <div class="form-group">
                        <!-- Button -->
                        <div class="col-sm-12 controls">
                            <button type="submit" href="#" class="btn btn-primary pull-right"><i class="glyphicon glyphicon-log-in"></i> Пријави се</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection

