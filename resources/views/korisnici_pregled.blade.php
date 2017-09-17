@extends('sabloni.app')

@section('naziv', 'Корисници | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">Преглед и измена детаља корисника {{$korisnik->name}}</h1>
    <h3 style="color: #18BC9C; margin-bottom: 40px">Број обрађених предмета: {{$broj_predmeta}}</h3>
@endsection

@section('sadrzaj')

    <form action="{{ route('korisnici.izmena',  $korisnik->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}
        
        <div class="row">
        <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Име и презиме: </label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $korisnik->name) }}" maxlength="255" required>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-6">
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="username">Корисничко име: </label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $korisnik->username) }}" maxlength="190" required>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>

        <hr>

        <div class="row">
        <div class="col-md-10 col-md-offset-1">
       <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">Лозинка: </label>
        <input type="password" name="password" id="password" class="form-control">
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>
        

        <div class="row">
        <div class="col-md-10 col-md-offset-1">
      <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password-confirm">Потврда лозинке: </label>
        <input type="password" name="password_confirmation" id="password-confirm" class="form-control">
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-10 col-md-offset-1">
       <div class="form-group{{ $errors->has('admin') ? ' has-error' : '' }} checkboxoviforme">
                <input type="checkbox" name="admin" id="admin" 
                {{ old('admin') ? ' checked' : '' }}
                {{ $korisnik->level == 0 ? ' checked' : '' }}
                >
                <label for="admin">&emsp;Да ли је корисник администратор?</label>
                @if ($errors->has('admin'))
                    <span class="help-block">
                        <strong>{{ $errors->first('admin') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        </div>

        <div class="row">
        <div class="col-md-10 col-md-offset-1">
        <div class="form-group text-right" style="margin-top: 40px">
            <button type="submit" class="btn btn-success"><i class="fa fa-pencil"></i> Измени</button>
            <a class="btn btn-danger" href="{{route('korisnici')}}"><i class="fa fa-ban"></i> Откажи измене</a>
        </div>
        </div>
        </div>
    </form>

@endsection

@section('traka')
<div class="well" style="margin-left: 30px">
<p class="text-primary" style="text-align: justify; text-justify: inter-word;"> Савети о одржавању тајновитости лозинке</p>
<p>НИКАДА немој другима откривати своју лозинку – ово укључује твоје другове и другарице, твог дечка или девојку, родбину, наставнике, друге ученике или студенте, као и људе са којима радиш. Ово се посебно односи на све непознате особе. НИКАДА немој записивати своје лозинке на папирићима које држиш поред компјутера. Осим што је релативно лако да неко нађе записану лозинку, папирић лако можеш да изгубиш. НИКАДА немој лозинку држати записану ни у свом мобилном телефону. Телефон може да буде украден или изгубљен, тако да ћеш, осим проблема самог изгубљеног телефона, морати да се бавиш и променама свих лозинки које су остале запамћене у том телефону. Стручњаци нису усаглашени у препорукама да ли је правилно записивати лозинке у свешчицу или блокчић који се држи даље од компјутера: неки препоручују овај поступак као безбедан начин да се корисник осигура да се лозинке неће изгубити, док су други стручњаци апсолутно против било каквог записивања. Чување тајности лозинке није и не може бити јединствено за сваког корисника. Свако од нас користи компјутере и интернет на различите начине и у различитим нивоима ризика. Најбоље је да најважније лозинке направиш тако да буду довољно безбедне, али лаке за памћење. На пример, ако користиш један е-маил који је повезан са свим твојим налозима на различитим друштвеним мрежама, нужно је да лозинка за е-маил буде јака и да је памтиш, док лозинке за друштвене мреже можеш да пробаш да запамтиш, али ако их и заборавиш, све друштвене мреже ће ти омогућити да лозинке твојих налога на врло једноставан начин ресетујеш.</p>
<br>
<hr style="border-top: 1px solid #18BC9C">
<img alt="katanac" class="center-block" src="{{url('/images/katanac.png')}}" style="height:80px">
</div>
@endsection

@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection