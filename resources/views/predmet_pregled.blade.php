@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <span><img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:64px"></span>
        &emsp; Преглед предмета број
        <span class="{{ $predmet->arhiviran == 0 ? 'text-success' : 'text-danger' }}">
            {{ $predmet->vrstaUpisnika->slovo }} {{ $predmet->broj_predmeta }}/{{ $predmet->godina_predmeta }}
            {{ $predmet->arhiviran == 0 ? '' : ' - (а/а)' }}
        </span>
    </h1>
@endsection

@section('sadrzaj')
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Датум:</div>
        <div class="col-md-9">{{ date('d.m.Y', strtotime($predmet->datum_tuzbe)) }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Суд:</div>
        <div class="col-md-9">{{ $predmet->sud->naziv }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Врста предмета:</div>
        <div class="col-md-9">{{ $predmet->vrstaPredmeta->naziv }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Катастарска парцела:</div>
        <div class="col-md-9">{{ $predmet->opis_kp }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Адреса:</div>
        <div class="col-md-9">{{ $predmet->opis_adresa }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Опис предмета:</div>
        <div class="col-md-9">{{ $predmet->opis }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Странка 1:</div>
        <div class="col-md-9">{{ $predmet->stranka_1 }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Странка 2:</div>
        <div class="col-md-9">{{ $predmet->stranka_2 }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Вредност тужбе:</div>
        <div class="col-md-9">{{ $predmet->vrednost_tuzbe }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Референт:</div>
        <div class="col-md-9">{{ $predmet->referent->ime }} {{ $predmet->referent->prezime }}</div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Предмет родитељ:</div>
        <div class="col-md-9">
        @if($predmet->roditelj)
            {{ $predmet->roditelj->vrstaUpisnika->slovo }}
            {{ $predmet->roditelj->broj_predmeta }}/{{ $predmet->roditelj->godina_predmeta }}
        @endif
        </div>
    </div>
    <div class="row" style="margin-bottom: 2rem;">
        <div class="col-md-3">Напомена:</div>
        <div class="col-md-9">{{ $predmet->napomena }}</div>
    </div>
@endsection

@section('traka')
<div class="well bullets">
    <h3 style="margin-bottom: 20px">Рочишта</h3>
    <hr style="border-top: 1px solid #18BC9C">
    <table class="table table-striped">
                <tbody>
                @foreach ($predmet->rocista as $rociste)
                        <tr>
                            <td style="width: 15%;"><span class="text-success">{{ $rociste->tipRocista->naziv }}</span> </td>
                            <td style="width: 15%;"><strong>{{ date('d.m.Y', strtotime($rociste->datum)) }}</strong></td>
                            <td style="width: 10%;">{{ date('H:i', strtotime($rociste->vreme)) }} </td>
                            <td style="width: 40%;"><i>{{ $rociste->opis }}</i></td>
                            <td style="width: 20%; text-align:center">
                    
                    <button class="btn btn-success btn-xs otvori_izmenu" id="dugmeIzmena" data-toggle="modal" data-target="#editModal" value="{{$rociste->id}}"><i class="fa fa-pencil" style="font-size: 0.875em;"></i></button>
                    <button id="dugmeBrisanje" class="btn btn-danger btn-xs otvori_modal"  value="{{$rociste->id}}"><i class="fa fa-trash" style="font-size: 0.875em;"></i></button>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
<hr style="border-top: 1px solid #18BC9C">
    <div class="row">
    <button style="float: right; margin-right: 10px" class="btn btn-success btn-sm otvori_dodavanje_rocista" id="dugmeDodajRociste" data-toggle="modal" data-target="#dodajModal" value="{{$predmet->id}}"><i class="fa fa-plus"></i></button>
    </div>
</div>
<div class="well">
    <h3>Токови</h3>
    <hr style="border-top: 1px solid #18BC9C">
    @foreach ($predmet->tokovi as $tok)
        {{ date('d.m.Y', strtotime($tok->datum)) }} -
        {{ $tok->status->naziv }} ({{ $tok->opis }})<br>
        Вредност спора потражује: {{ $tok->vrednost_spora_potrazuje }}<br>
        Вредност спора дугује: {{ $tok->vrednost_spora_duguje }}<br>
        Износ трошкова потражује: {{ $tok->iznos_troskova_potrazuje }}<br>
        Износ трошкова дугује: {{ $tok->iznos_troskova_duguje }}<br>
    @endforeach
</div>
<div class="well">
    <h3>Управе</h3>
    <hr style="border-top: 1px solid #18BC9C">
    @foreach ($predmet->uprave as $uprava)
    <p>
        {{ $uprava->sifra }} - {{ $uprava->naziv }}
        {{ $uprava->napomena }}
    </p>
    @endforeach
</div>
{{-- Pocetak Modala za dijalog dodavanje--}}
<div class="modal fade" id="dodajModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title text-primary">Додај рочиште</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('rocista.dodavanje.post') }}" method="POST">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('datum') ? ' has-error' : '' }}">
                                <label for="datum">Датум: </label>
                                <input type="date" name="datum" id="datum" class="form-control" value="{{ old('datum') }}"> @if ($errors->has('datum'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('datum') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('vreme') ? ' has-error' : '' }}">
                                <label for="vreme">Време: </label>
                                <input type="time" name="vreme" id="vreme" class="form-control" value="{{ old('vreme') }}"> @if ($errors->has('vreme'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('vreme') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('tip_id') ? ' has-error' : '' }}">
                                <label for="tip_id">Типови рочишта:</label>
                                <select name="tip_id" id="tip_id" class="chosen-select form-control" data-placeholder="Тип рочишта">
                                    <option value=""></option>
                                    @foreach($tipovi_rocista as $tip)
                                    <option value="{{ $tip->id }}"{{ old('tip_id') == $tip->id ? ' selected' : '' }}>
                                        <strong>{{ $tip->naziv }}</strong>
                                    </option>
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
                    <hr style="border-top: 2px solid #18BC9C">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('opis') ? ' has-error' : '' }}">
                                <label for="opis">Опис: </label>
                                <TEXTAREA name="opis" id="opis" class="form-control" rows="3">{{old('opis') }}</TEXTAREA> @if ($errors->has('opis'))
                                <span class="help-block">
                    <strong>{{ $errors->first('opis') }}</strong>
                </span> @endif
                            </div>
                        </div>
                    </div>
              <button type="submit" class="btn btn-success">Додај</button>
              <input type="hidden" id="predmet_id" name="predmet_id" value="{{$predmet->id}}">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Откажи</button>
          </div>
        </div>

    </div>
</div>
    {{-- Kraj Modala za dijalog dodavanje--}}

    {{-- Modal za dijalog brisanje--}}
    <div class="modal fade" id="brisanjeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h3 class="modal-title" id="brisanjeModalLabel">Упозорење!</h3>
            </div>
            <div class="modal-body">
                <h3 class="text-primary">Да ли желите трајно да обришете рочиште</strong></h3>
                <h4 id="tip_a" name="tip_a"></h4>
                <p><strong>Ова акција је неповратна!</strong></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-obrisi">Обриши</button>
            <button type="button" class="btn btn-danger" id="btn-otkazi">Откажи</button>
            </div>
        </div>
      </div>
  </div>
    {{-- Kraj Modala za dijalog brisanje--}}

    {{-- POcetak Modala za dijalog izmena--}}
    <div class="modal fade" id="editModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title text-primary">Измени детаље рочишта</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('rocista.izmena') }}" method="POST">
              {{ csrf_field() }}

                <div class="form-group">
                  <label for="tip_idm">Тип рочишта:</label>
                  <select class="form-control" name="tip_idm" id="tip_idm" data-placeholder="рочиште ...">
                    </select>
                </div>

                <div class="form-group">
                  <label for="datumm">Датум:</label>
                  <input type="date" class="form-control" id="datumm" name="datumm">
                </div>

                <div class="form-group">
                  <label for="vremem">Време:</label>
                  <input type="time" class="form-control" id="vremem" name="vremem">
                </div>

                <div class="form-group">
                    <label for="opism">Опис:</label>
                    <textarea class="form-control" rows="3" id="opism" name="opism"></textarea>
                </div>

              <button type="submit" class="btn btn-success">Измени</button>
              <input type="hidden" id="edit_id" name="edit_id">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Затвори</button>
          </div>
          
        </div>
        
      </div>
    </div>
    {{-- Kraj Modala za dijalog izmena--}}
@endsection

 @section('skripte')
<script>
$( document ).ready(function() {
    
    var detalj_ruta = "{{ route('rocista.detalj') }}";
    var ruta_brisanje = "{{ route('rocista.brisanje') }}";

    $('#dodajModal').on('shown.bs.modal', function () {
    $('.chosen-select', this).chosen({allow_single_deselect: true});});

    //Brisanje modal
    $(document).on('click','.otvori_modal',function(){

        var id_brisanje = $(this).val();     
        
        $('#brisanjeModal').modal('show');

        $.ajax({
        url: detalj_ruta,
        type:"GET", 
        data: {"id":id_brisanje},
        success: function(result){
          //$("#datum_a").text(result.rociste.datum);
          $("#vreme_a").text(result.rociste.vreme);
          if (result.rociste.tip_id==1) {
            $("#tip_a").html('Рок <span class="label label-success">Дана '+result.rociste.datum+' у '+result.rociste.vreme+' сати</span>');
          } else {
            $("#tip_a").text('Рочиште');
          }    
        }
      });

        $('#btn-obrisi').click(function(){
            $.ajax({
            url: ruta_brisanje,
            type:"POST", 
            data: {"id":id_brisanje, _token: "{!! csrf_token() !!}"}, 
            success: function(){
            location.reload(); 
          }
        });

        $('#brisanjeModal').modal('hide');
        });
        $('#btn-otkazi').click(function(){
            $('#brisanjeModal').modal('hide');
        });
    });
    //Izmene modal
    $(document).on('click','.otvori_izmenu',function(){

        var id_menjanje = $(this).val();

        $.ajax({
        url: detalj_ruta,
        type:"GET", 
        data: {"id":id_menjanje},
        success: function(result){
          $("#edit_id").val(result.rociste.id);
          $("#datumm").val(result.rociste.datum);
          $("#vremem").val(result.rociste.vreme);
          $("#opism").val(result.rociste.opis);
          
            $.each(result.tipovi_rocista, function(index, lokObjekat){
            $('#tip_idm').append('<option value="'+lokObjekat.id+'">'+lokObjekat.naziv+'</option>');
            });
            $("#tip_idm").val(result.rociste.tip_id);
        }
      });     

    });
});

</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection 

