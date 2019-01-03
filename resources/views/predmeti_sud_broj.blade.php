@extends('sabloni.app')

@section('naziv', 'Предмети | Бројеви у суду')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
        <h1>
            <img class="slicica_animirana" alt="... бројеви у суду"
                 src="{{url('/images/predmeti.png')}}" style="height:64px;">
            &emsp;Бројеви у суду предмета <small class="text-success"><em>({{$predmet->broj()}})</em></small>
        </h1>
    </div>
 <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a href="{{ route('predmeti.pregled', $predmet->id) }}" class="btn btn-primary btn-block ono">
                    <i class="fa fa-arrow-circle-left"></i> Назад на предмет
                </a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
   <hr>
</div>
</div>
@endsection

@section('sadrzaj')
  @if($sud_brojevi->isEmpty())
            <h3 class="text-danger">Овај предмет нема бројеве у суду</h3>
        @else
        <div class="row" style="margin-top: 4rem;">
            <div class="col-md-12">
            <table class="table table-striped tabelaStari" name="tabelaStari" id="tabelaStari">
                <thead>
                        <th style="width: 80%;">Број </th>
                        <th style="text-align:center; width: 20%;"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody>
                @foreach ($sud_brojevi as $v)
                        <tr>
                            <td><strong>{{$v->broj}}</strong></td>
                            <td style="text-align:center">
                    <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori-brisanje"  
                    data-toggle="modal" data-target="#brisanjeModal"
                    value="{{$v->id}}"><i class="fa fa-trash"></i></button>
                    <button class="btn btn-success btn-sm otvori-izmenu" data-toggle="modal" data-target="#editModal" value="{{ $v->id }}">
                    <i class="fa fa-pencil"></i>
                </button>
                            </td>
                        </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
        @endif

        {{-- Modal za dijalog brisanje--}}
<div id = "brisanjeModal" class = "modal fade">
    <div class = "modal-dialog">
        <div class = "modal-content">
            <div class = "modal-header">
                <button class = "close" data-dismiss = "modal">&times;</button>
                <h1 class = "modal-title text-danger">Упозорење!</h1>
            </div>
            <div class = "modal-body">
                <h3>Да ли желите трајно да уклоните број у суду? *</h3>
                <p class = "text-danger">* Ова акција је неповратна!</p>
                <form id="brisanje-forma" action="" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" id="idBrisanje" name="idBrisanje">
                    <hr style="margin-top: 30px;">

            <div class="row dugmici" style="margin-top: 30px;">
            <div class="col-md-12" >
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button id = "btn-brisanje-obrisi" type="submit" class="btn btn-danger btn-block ono">
                            <i class="fa fa-recycle"></i>&emsp;Уклони
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-primary btn-block ono" data-dismiss="modal">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
                </form>
            </div>
        </div>
    </div>
</div>
    {{-- Kraj Modala za dijalog brisanje--}}

    {{-- Pocetak Modala za dijalog izmena--}}
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title text-primary">Измени број предмета код надлежног органа</h2>
            </div>
            <div class="modal-body">
                <form action="{{ route('predmeti.sud_broj.izmena') }}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="brojModal">Број:</label>
                        <input type="text" class="form-control" id="brojModal" name="brojModal">
                    </div>

                    <input type="hidden" id="idModal" name="idModal">
                    <hr>

                                <div class="row dugmici" style="margin-top: 30px;">
            <div class="col-md-12" >
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button id = "btn-snimi" type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-save"></i>&emsp;Сними измене
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-primary btn-block ono" data-dismiss="modal">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
                </form>
            </div>
        </div>
    </div>
</div>
    {{-- Kraj Modala za dijalog izmena--}}
@endsection

@section('traka')
<h3 >Додавање старог броја</h3>
<hr>
<div class="well">
    <form action="{{route('predmeti.sud_broj.dodavanje', $predmet->id)}}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('broj') ? ' has-error' : '' }}">
            <label for="broj">Број у суду: </label>
            <input type="text" name="broj" id="broj" maxlength="50" class="form-control" required>{{ old('broj') }}</input>
            @if ($errors->has('broj'))
                <span class="help-block">
                    <strong>{{ $errors->first('broj') }}</strong>
                </span>
            @endif
        </div>

        <div class="row dugmici">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-plus"></i>&emsp;Додај
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {

    jQuery(window).on('resize', resizeChosen);

    $('.chosen-select').chosen({
        allow_single_deselect: true
    });

    function resizeChosen() {
        $(".chosen-container").each(function () {
            $(this).attr('style', 'width: 100%');
        });
    }

        $('#tabelaStari').DataTable({
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

        $(document).on('click', '.otvori-brisanje', function () {
            var id = $(this).val();
            $('#idBrisanje').val(id);
            var ruta = "{{ route('predmeti.sud_broj.brisanje') }}";
            console.log(ruta);
            console.log(id);
            $('#brisanje-forma').attr('action', ruta);
        });

                $(document).on('click','.otvori-izmenu',function(){
        
        var id = $(this).val();
        var ruta = "{{ route('predmeti.sud_broj.detalj') }}";

        $.ajax({
        url: ruta,
        type:"POST", 
        data: {"id":id, _token: "{!! csrf_token() !!}"},
        success: function(data){
          $("#idModal").val(data.id);
          $("#brojModal").val(data.broj);
        }
      });     

    });
});
</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection