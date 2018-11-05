@extends('sabloni.app')

@section('naziv', 'Предмети | Везе')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="row">
    <div class="col-md-10">
        <h1>
            <img class="slicica_animirana" alt="Коминтенти"
                 src="{{url('/images/korisnik.png')}}" style="height:64px;">
            &emsp;Тужилац/Тужени у предмету број <small class="text-success"><em>({{$predmet->broj()}})</em></small>
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

<!--Tuzioci-->
@if($tuzioci->isEmpty())
<h3 class="text-danger">Тренутно нема тужилаца</h3>
@else
<div class="row" style="margin-top: 4rem;">
    <div class="col-md-12">
        <table class="table table-striped tabelaTuzioci" name="tabelaTuzioci" id="tabelaTuzioci">
            <thead>
            <th style="width: 20%;">Име/Назив</th>
            <th style="width: 15%;">ЈМБГ/ПИБ</th>
            <th style="width: 20%;">Место</th>
            <th style="width: 20%;">Адреса</th>
            <th style="width: 20%;">Телефон</th>
            <th style="text-align:center; width: 5%;"><i class="fa fa-cogs"></i></th>
            </thead>
            <tbody id="sudovi_lista" name="sudovi_lista">
                @foreach ($tuzioci as $s1)
                <tr>
                   <td><strong>{{ $s1->naziv }}</strong></td> <!-- ovde ide link-->
                    <td>{{ $s1->id_broj }}</td>
                    <td>{{ $s1->mesto }}</td>
                    <td>{{ $s1->adresa }}</td>
                    <td>{{ $s1->telefon }}</td>

                    <td style="text-align:center">
                        <button id="dugmeBrisanje" class="btn btn-danger btn-sm otvori-brisanje"
                                data-toggle="modal" data-target="#brisanjeModal"
                                value="{{$s1->id}}"><i class="fa fa-trash"></i></button>
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
                <h3>Да ли желите трајно да уклоните везу? *</h3>
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
@endsection

@section('traka')
<h3>Додај коминтента</h3>
<hr>
<div class="well">
    <form action="{{ route('predmeti.veze.dodavanje', $predmet->id) }}" method="POST" data-parsley-validate>
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('komintent') ? ' has-error' : '' }}">
            <label for="komintent">Коминтент:</label>
            <select name="komintent" id="komintent" class="chosen-select form-control" data-placeholder="коминтенти" required>
                <option value=""></option>
                @foreach($svi_komintenti as $k)
                <option  value="{{ $k->id }}"{{ old('komintent') == $k->id ? ' selected' : '' }}>
                         {{ $k->naziv }} - {{ $k->id_broj }}</option>
                @endforeach
            </select>
            @if ($errors->has('komintent'))
            <span class="help-block">
                <strong>{{ $errors->first('komintent') }}</strong>
            </span>
            @endif
        </div>

        <div class="row dugmici">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success btn-block ono">
                            <i class="fa fa-link"></i>&emsp;Додај коминтента као тужиоца
                        </button>
                    </div>
        </div>
        <div class="row dugmici">
                    <div class="col-md-12">
                        <a class="btn btn-danger btn-block ono" href="{{ route('komintenti', $predmet->id) }}">
                            <i class="fa fa-ban"></i>&emsp;Откажи
                        </a>
                    </div>
        </div>
    </form>
</div>
@endsection

@section('skripte')
<script>
    $(document).ready(function() {

    jQuery(window).on('resize', resizeChosen);
    $('.chosen-select').chosen({
    allow_single_deselect: true
    });
    function resizeChosen() {
    $(".chosen-container").each(function () {
    $(this).attr('style', 'width: 100%');
    });
    }
    $(document).on('click', '.otvori-brisanje', function () {
    var id = $(this).val();
    $('#idBrisanje').val(id);
    var ruta = "{{ route('predmeti.veze.brisanje', "pid") }}";
    ruta = ruta.replace('pid', {!!$predmet->id!!});
    console.log(ruta);
    console.log(id);
    $('#brisanje-forma').attr('action', ruta);
    });
    });</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection
