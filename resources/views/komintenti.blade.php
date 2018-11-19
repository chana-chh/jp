@extends('sabloni.app')

@section('naziv', 'Коминтенти')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header">Коминтенти</h1>
@endsection

@section('sadrzaj')

<table class="table table-striped tabelaKomintenti" name="tabelaKomintenti" id="tabelaKomintenti">
    <thead>
    <th style="width: 5%;">#</th>
    <th style="width: 23%;">Назив</th>
    <th style="width: 12%;">Матични број</th>
    <th style="width: 15%;">Место</th>
    <th style="width: 25%;">Адреса</th>
    <th style="width: 10%;">Телефон</th>
    <th style="width: 10%; text-align:center"><i class="fa fa-cogs"></i></th>
</thead>
</table>
<h5>Иди на страницу</h5>
<button id="dugmeSkok" class="btn btn-warning btn-sm"><i class="fa fa-rocket"></i></button>
<input type="number" name="skok" id="skok">

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
<h3 >Додавање новог коминтента</h3>
<hr>
<div class="well">
    <form action="{{ route('komintenti.dodavanje') }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('naziv') ? ' has-error' : '' }}">
            <label for="naziv">Назив коминтента:</label>
            <input type="text" name="naziv" id="naziv" class="form-control" value="{{ old('naziv') }}" maxlength="190" required>
            @if ($errors->has('naziv'))
            <span class="help-block">
                <strong>{{ $errors->first('naziv') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('id_broj') ? ' has-error' : '' }}">
            <label for="id_broj">Матични број:</label>
            <input type="text" name="id_broj" id="id_broj" class="form-control" value="{{ old('id_broj') }}" maxlength="20" required>
            @if ($errors->has('id_broj'))
            <span class="help-block">
                <strong>{{ $errors->first('id_broj') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('mesto') ? ' has-error' : '' }}">
            <label for="mesto">Место:</label>
            <input type="text" name="mesto" id="mesto" class="form-control" value="{{ old('mesto') }}" maxlength="255">
            @if ($errors->has('mesto'))
            <span class="help-block">
                <strong>{{ $errors->first('mesto') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('adresa') ? ' has-error' : '' }}">
            <label for="adresa">Адреса:</label>
            <input type="text" name="adresa" id="adresa" class="form-control" value="{{ old('adresa') }}" maxlength="255">
            @if ($errors->has('adresa'))
            <span class="help-block">
                <strong>{{ $errors->first('adresa') }}</strong>
            </span>
            @endif
        </div>
        <div class="form-group{{ $errors->has('telefon') ? ' has-error' : '' }}">
            <label for="telefon">Телефон:</label>
            <input type="text" name="telefon" id="telefon" class="form-control" value="{{ old('telefon') }}" maxlength="255">
            @if ($errors->has('telefon'))
            <span class="help-block">
                <strong>{{ $errors->first('telefon') }}</strong>
            </span>
            @endif
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
                        <a class="btn btn-danger btn-block ono" href="{{route('statusi')}}">
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
    $(document).ready(function () {

        $('textarea').each(function () {
            this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
        }).on('input', function () {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });



        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        var tabela = $('#tabelaKomintenti').DataTable({

            processing: true,
            serverSide: true,
            ajax: {
            url: '{!! route('komintenti.ajax') !!}',
            type: "POST"
            },
            columns: [
            {data:'id', name:'id'},
            {data:'naziv', name:'naziv'},
            {data:'id_broj', name:'id_broj'},
            {data:'mesto', name:'mesto'},
            {data:'adresa', name:'adresa'},
            {data:'telefon', name:'telefon'},
            {data: null,
                className: 'align-middle text-center',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    var ruta = "{{ route('komintenti.pregled', 'data_id') }}";
                    var ruta_id = ruta.replace('data_id', data.id);
                    return '<a class="btn btn-success btn-sm otvori_izmenu" id="dugmeIzmena"  href="' + ruta_id + '"><i class="fa fa-pencil"></i></a> <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori_modal"  value="'+data.id+'"><i class="fa fa-trash"></i></button>';
                },
                name: 'akcije'},
            ],
            language: {
                search: "Пронађи у табели",
                paginate: {
                    first: "Прва",
                    previous: "Претходна",
                    next: "Следећа",
                    last: "Последња"
                },
                processing: "Процесирање у току ...",
                lengthMenu: "Прикажи _MENU_ елемената",
                zeroRecords: "Није пронађен ниједан запис за задати критеријум",
                info: "Приказ _START_ до _END_ од укупно _TOTAL_ елемената",
                infoFiltered: "(филтрирано од _MAX_ елемената)"
            }
        });

        $( "#skok" ).focus(function() {
        var info = tabela.page.info();
        var poslednja = info.pages;
        $("#skok").prop('max',poslednja);
        });

        $('#dugmeSkok').on( 'click', function () {
            var broj = parseInt($("#skok").val());
            tabela.page(broj-1).draw( 'page' );
        } );

        $(document).on('click', '.otvori_modal', function () {
            var id = $(this).val();
            var ruta = "{{ route('komintenti.brisanje') }}";
            $('#brisanjeModal').modal('show');
            $('#btn-obrisi').click(function () {
                $.ajax({
                    url: ruta,
                    type: "POST",
                    data: {"id": id, _token: "{!! csrf_token() !!}"},
                    success: function () {
                        location.reload();
                    }
                });

                $('#brisanjeModal').modal('hide');
            });
            $('#btn-otkazi').click(function () {
                $('#brisanjeModal').modal('hide');
            });
        });
    });
</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection
