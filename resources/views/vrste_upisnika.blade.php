@extends('sabloni.app')

@section('naziv', 'Врсте уписника')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <div class="row">
    <div class="col-md-10">
    <h1>
        <img class="slicica_animirana" alt="Врсте уписника"
                 src="{{url('/images/log.png')}}" style="height:64px;">
            &emsp;Врсте уписника
    </h1>
        </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <form action="{{ route('predmeti.dodavanje.post') }}" method="POST" data-parsley-validate>
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('godina_predmeta') ? ' has-error' : '' }}">
                    <label for="godina_predmeta">Година: </label>
                    <input type="number" name="godina_predmeta" id="godina_predmeta" class="form-control"
                           value="{{ old('godina_predmeta') ? old('godina_predmeta') : (int) date('Y', time()) }}"
                           min="2016" max="2030" step="1" required>
                    @if ($errors->has('godina_predmeta'))
                    <span class="help-block">
                        <strong>{{ $errors->first('godina_predmeta') }}</strong>
                    </span>
                    @endif
                </div>
        </form>
         </div>
     </div>
         <hr>
@endsection

@section('sadrzaj')
            <table class="table table-striped tabelaVrsteUpisnika" name="tabelaVrsteUpisnika" id="tabelaVrsteUpisnika">
                <thead>
                      <th style="width: 7%;">#</th>
                      <th style="width: 30%;">Назив</th>
                      <th style="width: 10%;">Акроним</th>
                      <th style="width: 15%;">Следећи број</th>
                      <th style="width: 28%;">Напомена</th>
                      <th style="width: 10%; text-align:center"><i class="fa fa-cogs"></i></th>
                </thead>
                <tbody id="vrste_upisnika_lista" name="vrste_upisnika_lista">
                </tbody>
            </table>

        {{-- Modal za dijalog brisanje--}}
    <div class="modal fade" id="brisanjeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="brisanjeModalLabel">Упозорење!</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-primary">Да ли желите трајно да обришете ставку</strong></h4>
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
<h3 >Додавање нове врсте уписника</h3>
<hr>
<div class="well">
    <form action="{{ route('vrste_upisnika.dodavanje') }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="row">
        <div class="col-md-9">
        <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
            <label for="naziv">Врста уписника (назив): </label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv') }}" required>
            @if ($errors->has('naziv'))
                <span class="help-block">
                    <strong>{{ $errors->first('naziv') }}</strong>
                </span>
            @endif
        </div>
        </div>

        <div class="col-md-3">
        <div class="form-group{{ $errors->has('slovo') ? ' has-error' : '' }}">
            <label for="slovo">Акроним: </label>
            <input type="text" name="slovo" id="slovo" class="form-control" value="{{ old('slovo') }}" required maxlength="5">
            @if ($errors->has('slovo'))
                <span class="help-block">
                    <strong>{{ $errors->first('slovo') }}</strong>
                </span>
            @endif
        </div>
        </div>
        </div>

        <div class="form-group{{ $errors->has('napomena') ? ' has-error' : '' }}">
            <label for="napomena">Напомена: </label>
            <textarea name="napomena" id="napomena" maxlength="255" class="form-control">{{ old('napomena') }}</textarea>
            @if ($errors->has('napomena'))
                <span class="help-block">
                    <strong>{{ $errors->first('napomena') }}</strong>
                </span>
            @endif
        </div>
        
        <div class="row dugmici">
            <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                    <div class="col-md-6 snimi">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-plus-circle"></i>&emsp;Додај
                        </button>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-danger btn-block ono" href="{{route('vrste_upisnika')}}">
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


        napraviTabelu($("#godina_predmeta").val());
        
        $('textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
            }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        $("#godina_predmeta").on('change', function () {
            napraviTabelu($(this).val());
        });

        function napraviTabelu(vrednost){
            $.ajax({
                type : 'get',
                url : '{{URL::to('tabelaUpisnici')}}',
                data : {'upitTabela':vrednost},
                success:function(data){
                $('#vrste_upisnika_lista').html(data);
                }
            });
        };

        $('#tabelaVrsteUpisnika').DataTable({
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
        
        var ruta = "{{ route('vrste_upisnika.brisanje') }}";


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