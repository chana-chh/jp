@extends('sabloni.app')

@section('naziv', 'Корисници')

@section('meni')
    @include('sabloni.inc.meni')
@endsection



@section('naslov')
    <h1 class="page-header">Корисници</h1>
@endsection

@section('sadrzaj')
<h2 >Листа активних корисника</h2>
<hr>
  @if($korisnici->isEmpty())
            <h3 class="text-danger">Тренутно нема корисника у бази</h3>
        @else
            <table class="table table-striped tabelaKorisnici" name="tabelaKorisnici" id="tabelaKorisnici">
                <thead>
                      <th>#</th>
                      <th>Име и презиме</th>
                      <th>Корисничко име</th>
                      <th>Администратор</th>
                      <th style="text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="korisnici_lista" name="korisnici_lista">
                @foreach ($korisnici as $korisnik)
                        <tr>
                                <td>{{$korisnik->id}}</td>
                                <td><strong>{{$korisnik->name}}</strong></td>
                                <td>{{$korisnik->username}}</td>
                                <td style="text-align:center">{!! $korisnik->level == 0 ? '<i class="fa fa-check text-success">' : '' !!}</td>
                                 <td style="text-align:center">
                                 <a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena"  href="{{ route('korisnici.pregled', $korisnik->id) }}"><i class="fa fa-eye"></i></a>
                    <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori_modal"  value="{{$korisnik->id}}"><i class="fa fa-trash"></i></button>
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
                <h4 class="text-primary">Да ли желите трајно да обришете корисника</strong></h4>
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
<h3 >Додавање корисника</h3>
<hr>
<div class="well">
    <form action="{{ route('korisnici.dodavanje') }}" method="POST">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Име и презиме: </label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" maxlength="255" required>
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="username">Корисничко име: </label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" maxlength="190 " required>
            @if ($errors->has('username'))
                <span class="help-block">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
        </div>

          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password">Лозинка:</label>
        <input type="password" name="password" id="password" class="form-control" minlength="4" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <label for="password-confirm">Потврда лозинке:</label>
        <input type="password" name="password_confirmation" id="password-confirm" class="form-control" minlength="4" required>
            @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group checkboxoviforme">
                <label><input type="checkbox" name="admin" id="admin"> &emsp;Да ли је корисник администратор?</label>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-success"><i class="fa fa-plus-circle"></i> Додај</button>
            <a class="btn btn-danger" href="{{route('korisnici')}}"><i class="fa fa-ban"></i> Откажи</a>
        </div>
    </form>
</div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {

        $('#tabelaKorisnici').DataTable({

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
        
        var ruta = "{{ route('korisnici.brisanje') }}";


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
@endsection