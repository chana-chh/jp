@extends('sabloni.app')

@section('naziv', 'Предмети')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header">
        <img alt="предмети" src="{{url('/images/predmeti.png')}}" style="height:50px;">
        Преглед предмета број
        <span class="{{ $predmet->arhiviran == 0 ? 'text-success' : 'text-danger' }}">
            {{ $predmet->broj() }}
            {{ $predmet->arhiviran == 0 ? '' : ' - (а/а)' }}
        </span>
    </h1>
@endsection

@section('sadrzaj')
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="{{ route('predmeti') }}" class="btn btn-primary"><i class="fa fa-arrow-circle-left"></i> Назад на предмете</a>
            <a href="{{ route('predmeti.izmena.get', $predmet->id) }}" class="btn btn-success"><i class="fa fa-pencil"></i> Измени</a>
        </div>
    </div>
    <table class="table table-striped" style="table-layout: fixed;">
        <tbody>
            <tr>
                <th style="width: 20%;">Датум</th>
                <td style="width: 80%;">{{ date('d.m.Y', strtotime($predmet->datum_tuzbe)) }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Суд</th>
                <td style="width: 80%;">{{ $predmet->sud->naziv }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Врста предмета</th>
                <td style="width: 80%;">{{ $predmet->vrstaPredmeta->naziv }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Катастарска парцела</th>
                <td style="width: 80%;">{{ $predmet->opis_kp }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Адреса</th>
                <td style="width: 80%;">{{ $predmet->opis_adresa }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Опис предмета</th>
                <td style="width: 80%;">{{ $predmet->opis }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Странка 1</th>
                <td style="width: 80%;">{{ $predmet->stranka_1 }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Странка 2</th>
                <td style="width: 80%;">{{ $predmet->stranka_2 }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Вредност тужбе</th>
                <td style="width: 80%;">{{ number_format($predmet->vrednost_tuzbe, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Референт</th>
                <td style="width: 80%;">{{ $predmet->referent->imePrezime() }}</td>
            </tr>
            <tr>
                <th style="width: 20%;">Предмет родитељ</th>
                <td style="width: 80%;">
                    @if($predmet->roditelj)
                        {{ $predmet->roditelj->broj() }}
                    @endif
                </td>
            </tr>
            <tr>
                <th style="width: 20%;">Напомена</th>
                <td style="width: 80%;">{{ $predmet->napomena }}</td>
            </tr>
        </tbody>
    </table>

    @if (Gate::allows('admin'))
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Мета информације о предмету</h3>
        </div>
        <div class="panel-body">
            <p>
                Корисник који је последњи вршио измене на предмету је
                <strong class="text-primary">{{ $predmet->korisnik->name }}</strong>
            </p>
            <p>
                Предмет је додат у базу
                <strong class="text-primary">{{ date('d.m.Y', strtotime($predmet->created_at)) }}</strong>
            </p>
            <p>
                Предмет је последњи пут измењен
                <strong class="text-primary">{{ date('d.m.Y', strtotime($predmet->updated_at)) }}</strong>
            </p>
        </div>
    </div>
    @endif
    {{--  POCETAK TOK_PREDMETA  --}}
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
        <hr style="border-top: 1px solid #18BC9C">
    </div>
    {{--  KRAJ TOK_PREDMETA  --}}
@endsection

@section('traka')
    {{--  POCETAK ROCISTA  --}}
    <div class="well" style="overflow: auto;">
        <h3 style="margin-bottom: 20px">Рочишта</h3>
        <hr style="border-top: 1px solid #18BC9C">
        <table class="table table-striped table-responsive">
            <tbody>
                @foreach ($predmet->rocista as $rociste)
                    <tr>
                        <td style="width: 15%;"><strong class="text-info">{{ $rociste->tipRocista->naziv }}</strong></td>
                        <td style="width: 15%;"><strong>{{ date('d.m.Y', strtotime($rociste->datum)) }}</strong></td>
                        <td style="width: 10%;"><strong>{{ date('H:i', strtotime($rociste->vreme)) }}</strong></td>
                        <td style="width: 40%;"><em>{{ str_limit($rociste->opis, 30) }}</em></td>
                        <td style="width: 20%; text-align: right;">
                            <button
                                class="btn btn-success btn-xs" id="dugmeRocisteIzmena"
                                data-toggle="modal" data-target="#izmeniRocisteModal" value="{{$rociste->id}}">
                                    <i class="fa fa-pencil"></i>
                            </button>
                            <button
                                class="btn btn-danger btn-xs" id="dugmeRocisteBrisanje"
                                value="{{$rociste->id}}">
                                    <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr style="border-top: 1px solid #18BC9C">
        <button
            class="btn btn-success btn-sm" id="dugmeDodajRociste"
            data-toggle="modal" data-target="#dodajRocisteModal" value="{{ $predmet->id }}">
                <i class="fa fa-plus-circle"></i> Додај рочиште
        </button>
    </div>

    {{--  pocetak modal_rocista_dodavanje  --}}
    <div class="modal fade" id="dodajRocisteModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-success">Додавање рока/рочишта</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rocista.dodavanje.post') }}" method="POST" id="frmRocisteDodavanje" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('rok_dodavanje_tip_id') ? ' has-error' : '' }}">
                                    <label for="rok_dodavanje_tip_id">Тип рочишта</label>
                                    <select name="rok_dodavanje_tip_id" id="rok_dodavanje_tip_id" class="chosen-select form-control"
                                        data-placeholder="Тип рочишта" required>
                                        <option value=""></option>
                                        @foreach($tipovi_rocista as $tip)
                                            <option value="{{ $tip->id }}"{{ old('rok_dodavanje_tip_id') == $tip->id ? ' selected' : '' }}>
                                                {{ $tip->naziv }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('rok_dodavanje_tip_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rok_dodavanje_tip_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('rok_dodavanje_datum') ? ' has-error' : '' }}">
                                    <label for="rok_dodavanje_datum">Датум</label>
                                    <input type="date" name="rok_dodavanje_datum" id="rok_dodavanje_datum" class="form-control"
                                    value="{{ old('rok_dodavanje_datum') }}" required>
                                    @if ($errors->has('rok_dodavanje_datum'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rok_dodavanje_datum') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('rok_dodavanje_vreme') ? ' has-error' : '' }}">
                                    <label for="rok_dodavanje_vreme">Време</label>
                                    <input type="time" name="rok_dodavanje_vreme" id="rok_dodavanje_vreme" class="form-control"
                                    value="{{ old('rok_dodavanje_vreme') }}" required>
                                    @if ($errors->has('rok_dodavanje_vreme'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rok_dodavanje_vreme') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr style="border-top: 2px solid #18BC9C">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('rok_dodavanje_opis') ? ' has-error' : '' }}">
                                    <label for="rok_dodavanje_opis">Опис</label>
                                    <textarea name="rok_dodavanje_opis" id="rok_dodavanje_opis" class="form-control">{{old('rok_dodavanje_opis') }}</textarea>
                                    @if ($errors->has('rok_dodavanje_opis'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rok_dodavanje_opis') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="dugmeModalDodajRociste">
                        <i class="fa fa-floppy-o"></i> Сними
                    </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-ban"></i> Откажи
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--  kraj modal_rocista_dodavanje  --}}

    {{--  pocetak modal_rocista_izmena  --}}
    <div class="modal fade" id="izmeniRocisteModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-warning">Измена рока/рочишта</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rocista.izmena') }}" method="POST" id="frmRocisteIzmena" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rok_izmena_tip_id">Тип рочишта</label>
                                    <select class="form-control" name="rok_izmena_tip_id" id="rok_izmena_tip_id" required>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rok_izmena_datum">Датум</label>
                                    <input type="date" class="form-control" id="rok_izmena_datum" name="rok_izmena_datum" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rok_izmena_vreme">Време</label>
                                    <input type="time" class="form-control" id="rok_izmena_vreme" name="rok_izmena_vreme" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rok_izmena_opis">Опис</label>
                                    <textarea class="form-control" id="rok_izmena_opis" name="rok_izmena_opis"></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="rok_izmena_id" name="rok_izmena_id">
                        <input type="hidden" id="predmet_id" name="predmet_id" value="{{ $predmet->id }}">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="dugmeModalIzmeniRociste">
                        <i class="fa fa-floppy-o"></i> Сними
                    </button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        <i class="fa fa-ban"></i> Откажи
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--  kraj modal_rocista_izmena  --}}

    {{--  pocetak modal_rocista_brisanje  --}}
    <div class="modal fade" id="brisanjeRocistaModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-danger">Брисање рока/рочишта</h3>
                </div>
                <div class="modal-body">
                    <h3>Да ли желите трајно да обришете?</h3>
                    <h4 id="brisanje_poruka"></h4>
                    <p class="text-danger">Ова акција је неповратна!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="dugmeModalObrisiRocisteBrisi">
                        <i class="fa fa-trash"></i> Обриши
                    </button>
                    <button type="button" class="btn btn-danger" id="dugmeModalObrisiRocisteOtazi">
                        <i class="fa fa-ban"></i> Откажи
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{--  kraj modal_rocista_brisanje  --}}

    {{--  KRAJ ROCISTA  --}}










    {{--  POCETAK UPRAVA  --}}
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
    {{--  KRAJ UPRAVA  --}}
@endsection

@section('skripte')
    <script>
        $( document ).ready(function() {
            var detalj_ruta = "{{ route('rocista.detalj') }}";
            var ruta_brisanje = "{{ route('rocista.brisanje') }}";

            // Modal rocista dodavanje
            $("#dugmeModalDodajRociste").on('click', function() {
                $('#frmRocisteDodavanje').submit();
            });

            //Izmene modal
            $("#dugmeModalIzmeniRociste").on('click', function() {
                $('#frmRocisteIzmena').submit();
            });

            $(document).on('click','#dugmeRocisteIzmena', function() {
                var id_menjanje = $(this).val();

                $.ajax({
                    url: detalj_ruta,
                    type:"GET",
                    data: {"id": id_menjanje},
                    success: function(result) {
                        $("#rok_izmena_id").val(result.rociste.id);
                        $("#rok_izmena_datum").val(result.rociste.datum);
                        $("#rok_izmena_vreme").val(result.rociste.vreme);
                        $("#rok_izmena_opis").val(result.rociste.opis);

                        $.each(result.tipovi_rocista, function(index, lokObjekat) {
                            $('#rok_izmena_tip_id').append('<option value="'+lokObjekat.id+'">'+lokObjekat.naziv+'</option>');
                        });

                        $("#rok_izmena_tip_id").val(result.rociste.tip_id);
                    }
                });

            });

            //Brisanje modal
            $(document).on('click', '#dugmeRocisteBrisanje', function() {
                var id_brisanje = $(this).val();

                $('#brisanjeRocistaModal').modal('show');

                $.ajax({
                    url: detalj_ruta,
                    type:"GET",
                    data: {"id": id_brisanje},
                    success: function(result) {
                        var datum = new Date(result.rociste.datum);
                        var mesec = datum.getMonth() + 1;
                        var d = datum.getDate() + '.' + mesec + '.' + datum.getFullYear();
                        if (result.rociste.tip_id == 1) {
                            $("#brisanje_poruka").text(
                                'Рок дана ' + d + ' у ' + result.rociste.vreme + ' сати'
                            );
                        } else {
                            $("#brisanje_poruka").text(
                                'Рочиште дана ' + d + ' у ' + result.rociste.vreme + ' сати'
                            );
                        }
                    }
                });

                $('#dugmeModalObrisiRocisteBrisi').on('click', function() {

                    $.ajax({
                        url: ruta_brisanje,
                        type:"POST",
                        data: {"id": id_brisanje, _token: "{!! csrf_token() !!}"},
                        success: function() {
                            location.reload();
                        }
                    });

                    $('#brisanjeRocistaModal').modal('hide');

                });

                $('#dugmeModalObrisiRocisteOtazi').on('click', function() {
                    $('#brisanjeRocistaModal').modal('hide');
                });
            });
        });
    </script>
    <script src="{{ asset('/js/parsley.js') }}"></script>
    <script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection

