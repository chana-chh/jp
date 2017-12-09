@extends('sabloni.app')

@section('naziv', 'Корисници | Преглед')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header"><img class="slicica_animirana" alt="Врсте уписника"
                 src="{{url('/images/korisnik.png')}}" style="height:64px;">
            &emsp;Преглед и измена детаља корисника {{$korisnik->name}}</h1>
    <h3 style="color: #18BC9C; margin-bottom: 40px">Број обрађених предмета: {{$broj_predmeta}}</h3>
    <div class="row" style="margin-bottom: 16px; margin-top: 16px">
    <div class="col-md-12">
        <div class="btn-group">
            <a class="btn btn-primary" onclick="window.history.back();"
               title="Повратак на претходну страну">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a class="btn btn-primary" href="{{ route('pocetna') }}"
               title="Повратак на почетну страну">
                <i class="fa fa-home"></i>
            </a>
            <a class="btn btn-primary" href="{{ route('korisnici') }}"
               title="Повратак на листу корисника">
                <i class="fa fa-list"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@section('sadrzaj')
    <div class="row ceo_dva">
    <div class="col-md-12 boxic">

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
         <div class="row dugmici">
        <div class="col-md-6 col-md-offset-6">
        <div class="form-group text-right ceo_dva">
        <div class="col-md-6 snimi">
            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-floppy-o"></i>&emsp;Сними</button>
        </div>
        <div class="col-md-6">
            <a class="btn btn-danger btn-block" href="{{route('korisnici')}}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
        </div>
        </div>
        </div>
        </div>
    </form>
</div>
</div>
@endsection

@section('traka')
<div class="well" style="margin-left: 20px;">
<p class="text-primary" style="text-align: justify; text-justify: inter-word;"> Савети о одржавању тајновитости лозинке</p>
<p>НИКАДА немој другима откривати своју лозинку – ово укључује твоје другове и другарице, твог дечка или девојку, родбину, наставнике, друге ученике или студенте, као и људе са којима радиш. Ово се посебно односи на све непознате особе. НИКАДА немој записивати своје лозинке на папирићима које држиш поред компјутера. Осим што је релативно лако да неко нађе записану лозинку, папирић лако можеш да изгубиш. НИКАДА немој лозинку држати записану ни у свом мобилном телефону. Телефон може да буде украден или изгубљен, тако да ћеш, осим проблема самог изгубљеног телефона, морати да се бавиш и променама свих лозинки које су остале запамћене у том телефону. Најбоље је да најважније лозинке направиш тако да буду довољно безбедне, али лаке за памћење. На пример, ако користиш један е-маил који је повезан са свим твојим налозима на различитим друштвеним мрежама, нужно је да лозинка за е-маил буде јака и да је памтиш, док лозинке за друштвене мреже можеш да пробаш да запамтиш, али ако их и заборавиш, све друштвене мреже ће ти омогућити да лозинке твојих налога на врло једноставан начин ресетујеш.</p>
<br>
<hr style="border-top: 1px solid #18BC9C">
<img alt="katanac" class="center-block" src="{{url('/images/katanac.png')}}" style="height:80px">
</div>
@endsection

@section('skripte')
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection