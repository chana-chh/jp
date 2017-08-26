@extends('sabloni.app')

@section('naziv', 'Рочишта')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/rokovi.png')}}" style="height:64px"></span>
        Додавање новог рочишта
    </h1>

   <form action="{{ route('rocista.dodavanje.post') }}" method="POST" style="margin-top: 45px">
              {{ csrf_field() }}
        
            <div class="row">
            <div class="col-md-10 col-md-offset-1">
            
            <div class="form-group{{ $errors->has('predmet_id') ? ' has-error' : '' }}" style="margin-right: 15px; margin-left: 15px">
                    <label for="predmet_id">Предмет:</label>
                    <select name="predmet_id" id="predmet_id" class="chosen-select form-control" data-placeholder="Предмети" >
                    <option value=""></option>
                    @foreach($predmeti as $predmet)
                    <option value="{{ $predmet->id }}"{{ old('predmet_id') == $predmet->id ? ' selected' : '' }}><strong>
                                    {{$predmet->vrstaUpisnika->slovo}} {{$predmet->broj_predmeta}}/{{$predmet->godina_predmeta}}, &emsp; {{$predmet->vrstaPredmeta->naziv}}, &emsp; {{$predmet->opis_kp}}, {{$predmet->opis_adresa}}, {{$predmet->opis}}
                                </strong></option>
                    @endforeach
                    </select>
                        @if ($errors->has('predmet_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('predmet_id') }}</strong>
                        </span>
                        @endif
                </div>
                </div>
                </div>


            <div class="row" style="margin-top: 15px">
            <div class="col-md-10 col-md-offset-1">
            <div class="col-md-4">
        <div class="form-group{{ $errors->has('datum') ? ' has-error' : '' }}">
            <label for="datum">Датум: </label>
            <input type="date" name="datum" id="datum" class="form-control" value="{{ old('datum') }}">
            @if ($errors->has('datum'))
                <span class="help-block">
                    <strong>{{ $errors->first('datum') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-4">
         <div class="form-group{{ $errors->has('vreme') ? ' has-error' : '' }}">
            <label for="vreme">Време: </label>
            <input type="time" name="vreme" id="vreme" class="form-control" value="{{ old('vreme') }}">
            @if ($errors->has('vreme'))
                <span class="help-block">
                    <strong>{{ $errors->first('vreme') }}</strong>
                </span>
            @endif
        </div>
        </div>

         <div class="col-md-4">
         <div class="form-group{{ $errors->has('tip_id') ? ' has-error' : '' }}">
                    <label for="tip_id">Типови рочишта:</label>
                    <select name="tip_id" id="tip_id" class="chosen-select form-control" data-placeholder="Тип рочишта" >
                    <option value=""></option>
                    @foreach($tipovi_rocista as $tip)
                    <option value="{{ $tip->id }}"{{ old('tip_id') == $tip->id ? ' selected' : '' }}><strong>{{ $tip->naziv }}</strong></option>
                    @endforeach
                    </select>
                        @if ($errors->has('tip_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('tip_id') }}</strong>
                        </span>
                        @endif
                </div>

        </div>
        </div>
        </div>
         <div class="row" style="margin-top: 15px">
        <div class="col-md-10 col-md-offset-1">
        <hr style="border-top: 2px solid #18BC9C">
        </div>
        </div>

        <div class="row" style="margin-top: 15px">
        <div class="col-md-10 col-md-offset-1">
        <div class="form-group{{ $errors->has('opis') ? ' has-error' : '' }}">
            <label for="opis">Опис: </label>
            <TEXTAREA name="opis" id="opis" class="form-control" rows="3">{{old('opis') }}</TEXTAREA>
            @if ($errors->has('opis'))
                <span class="help-block">
                    <strong>{{ $errors->first('opis') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>


        <div class="row" style="margin-top: 45px">
        <div class="col-md-10 col-md-offset-1">
        <div class="form-group text-right" style="margin-top: 20px">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Додај</button>
            <a class="btn btn-danger" href="{{route('rocista')}}"><i class="fa fa-ban"></i> Откажи</a>
        </div>
        </div>
        </div>

            </form>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {
    $('#tabelaRocista').DataTable({
        order: [[ 1, "desc" ]],
        responsive: true,
        language: {
            search: "Пронађи у табели",
            paginate: {
                first:      "Прва",
                previous:   "Претходна",
                next:       "Следећа",
                last:       "Последња"
            },
            processing:   "Процесирање у току...",
            lengthMenu:   "Прикажи _MENU_ елемената",
            zeroRecords:  "Није пронађен ниједан запис",
            info:         "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
            infoFiltered: "(filtrirano од укупно _MAX_ елемената)",
            

        }
    });

    $('.chosen-select').chosen({allow_single_deselect: true});

});
</script>
@endsection