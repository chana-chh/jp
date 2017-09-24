@extends('sabloni.app')

@section('naziv', 'Референти')

@section('meni')
    @include('sabloni.inc.meni')
@endsection



@section('naslov')
    <h1 class="page-header">Референти</h1>
@endsection

@section('sadrzaj')
<h2 >Листа активних референата</h2>
<hr>
  @if($referenti->isEmpty())
            <h3 class="text-danger">Тренутно нема референата у бази</h3>
        @else
            <table class="table table-striped tabelaReferenti" name="tabelaReferenti" id="tabelaReferenti">
                <thead>
                      <th>#</th>
                      <th>Име и презиме</th>
                      <th>Број предмета</th>
                      <th>Напомена</th>
                      <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="referenti_lista" name="referenti_lista">
                @foreach ($referenti as $referent)
                        <tr>
                                <td>{{$referent->id}}</td>
                                <td><strong>{{$referent->ime}} {{$referent->prezime}}</strong></td>
                                <td><strong>{{$referent->predmet->count()}}</strong></td>
                                <td>{{$referent->napomena}}</td>

                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena"  href="{{ route('referenti.pregled', $referent->id) }}"><i class="fa fa-pencil"></i></a>
                    <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori_modal"  value="{{$referent->id}}"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        {{-- Modal za dijalog brisanje--}}
    <div class="modal fade" id="brisanjeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="brisanjeModalLabel">Упозорење!</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-primary">Да ли желите трајно да обришете ставку</h4>
                <p ><strong>Ова акција је неповратна!</strong></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-obrisi">Обриши</button>
            <button type="button" class="btn btn-danger" id="btn-otkazi">Откажи</button>
            </div>
        </div>
      </div>
  </div>
    {{-- Kraj Modala za dijalog brisanje--}}
@endsection

@section('traka')
<h3 >Додавање референта</h3>
<hr>
<div class="well">
    <form action="{{ route('referenti.dodavanje') }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('ime') ? ' has-error' : '' }}">
            <label for="ime">Име: </label>
            <input type="text" name="ime" id="ime" class="form-control" value="{{ old('ime') }}" required>
            @if ($errors->has('ime'))
                <span class="help-block">
                    <strong>{{ $errors->first('ime') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('prezime') ? ' has-error' : '' }}">
            <label for="prezime">Презиме: </label>
            <input type="text" name="prezime" id="prezime" class="form-control" value="{{ old('prezime') }}" required>
            @if ($errors->has('prezime'))
                <span class="help-block">
                    <strong>{{ $errors->first('prezime') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
            <label for="napomena">Напомена: </label>
            <input type="text" name="napomena" id="napomena" class="form-control" value="{{ old('napomena') }}">
            @if ($errors->has('napomena'))
                <span class="help-block">
                    <strong>{{ $errors->first('napomena') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Додај</button>
            <a class="btn btn-danger" href="{{route('referenti')}}"><i class="fa fa-ban"></i> Откажи</a>
        </div>
    </form>
</div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {

        $('#tabelaReferenti').DataTable({
        columnDefs: [{ orderable: false, searchable: false, "targets": -1 }],
        language: {
        search: "Пронађи у таблеи",
            paginate: {
            first:      "Прва",
            previous:   "Претходна",
            next:       "Следећа",
            last:       "Последња"
        },
        processing:   "Процесирање у току ...",
        lengthMenu:   "Прикажи _MENU_ елемената",
        zeroRecords:  "Није пронађен ниједан запис за задати критеријум",
        info:         "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
        infoFiltered: "(филтрирано од _MAX_ елемената)",
    },
    });

    $(document).on('click','.otvori_modal',function(){

        var id = $(this).val();

        var ruta = "{{ route('referenti.brisanje') }}";


        $('#brisanjeModal').modal('show');

        $('#btn-obrisi').click(function(){
            $.ajax({
            url: ruta,
            type:"POST",
            data: {"id":id, _token: "{!! csrf_token() !!}"},
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
});
</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection