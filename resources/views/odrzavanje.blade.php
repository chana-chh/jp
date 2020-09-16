@extends('sabloni.app')

@section('naziv', 'Логови')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
<div class="alert alert-info alert-dismissible" id="poruka" role="alert" style="display: none">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
    <p id="tekst">Better check yourself, you're not looking too good.</p>
</div>
<div class="row">
    <div class="col-md-10">
        <h1><img class="slicica_animirana" alt="Одржавање" src="{{url('/images/odrzavanje.png')}}" style="height:64px;">
            &emsp;Одржавање
        </h1>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-8">
        <div class="jumbotron">
            <h3>Брисање логова</h3>
            <p>Ако желите да обришете све логове, односно акције корисника које су уписане у базу. Обрисани логови ће
                бити доступни у резервној копији базе података у наредних шест месеци.</p>
            @if (Gate::allows('admin'))
            <div class="text-right">
                <button type="button" class="btn btn-danger logovi">
                    <i class="fa fa-trash"></i> Обриши све логове
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-4 text-center">
        <h3>Тренутно логова у бази:</h3>
        <h2><span class="label label-primary">{{ $log }}</span></h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="jumbotron">
            <h3>Брисање замена референата</h3>
            <p>Ако желите да обришете све замене референата. Обрисане замене ће бити доступне у резервној копији базе
                података у наредних шест месеци.</p>
            @if (Gate::allows('admin'))
            <div class="text-right">
                <button type="button" class="btn btn-danger zamene">
                    <i class="fa fa-trash"></i> Обриши све замене
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-4 text-center">
        <h3>Тренутно референата на замени у бази:</h3>
        <h2><span class="label label-primary">{{$zamene}}</span></h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="jumbotron">
            <h3>Брисање кретања предмета</h3>
            <p>Ако желите да обришете сва кретања предмета осим последњег уписаног у базу. Обрисана кретања ће бити
                доступна у резервној копији базе података у наредних шест месеци.</p>
            @if (Gate::allows('admin'))
            <div class="text-right">
                <button type="button" class="btn btn-danger kretanja">
                    <i class="fa fa-trash"></i> Обриши сва кретања предмета
                </button>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-4 text-center">
        <h3>Тренутно записа о кретању предмета у бази:</h3>
        <h2><span class="label label-primary">{{$kretanja}}</span></h2>
    </div>
</div>

{{-- Modal za dijalog brisanje LOGOVI--}}
    <div class="modal fade" id="brisanjeLogovaModal" tabindex="-1" role="dialog" aria-labelledby="brisanjeLogova"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="brisanjeModalLabel">Упозорење!</h4>
                </div>
                <div class="modal-body">
                    <h4 class="text-primary">Да ли желите трајно да обришете све логове</h4>
                    <p><strong>Ова акција је неповратна!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-obrisi-logove">Обриши</button>
                    <button type="button" class="btn btn-danger" id="btn-otkazi-logove">Откажи</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Kraj Modala za dijalog brisanje LOGOVI--}}

    {{-- Modal za dijalog brisanje ZAMENE--}}
    <div class="modal fade" id="brisanjeZamene" tabindex="-1" role="dialog" aria-labelledby="brisanjeZamene"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="brisanjeModalZamene">Упозорење!</h4>
                </div>
                <div class="modal-body">
                    <h4 class="text-primary">Да ли желите трајно да обришете све замене референата</h4>
                    <p><strong>Ова акција је неповратна!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-obrisi-zamene">Обриши</button>
                    <button type="button" class="btn btn-danger" id="btn-otkazi-zamene">Откажи</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Kraj Modala za dijalog brisanje ZAMENE--}}

{{-- Modal za dijalog brisanje KRETANJE--}}
    <div class="modal fade" id="brisanjeKretanje" tabindex="-1" role="dialog" aria-labelledby="brisanjeKretanje"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="brisanjeModalZamene">Упозорење!</h4>
                </div>
                <div class="modal-body">
                    <h4 class="text-primary">Да ли желите трајно да обришете сва кретања предмета осим последњег</h4>
                    <p><strong>Ова акција је неповратна!</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-obrisi-kretanje">Обриши</button>
                    <button type="button" class="btn btn-danger" id="btn-otkazi-kretanje">Откажи</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Kraj Modala za dijalog brisanje KRETANJE--}}
@endsection

@section('skripte')
<script>
$( document ).ready(function() {

    $(document).on('click','.logovi',function(){

        var rutal = "{{ route('logovi.pospremanje') }}";

        $('#brisanjeLogovaModal').modal('show');

        $('#btn-obrisi-logove').click(function(){
            $.ajax({
            url: rutal,
            type:"POST",
            data: {_token: "{!! csrf_token() !!}"},
            success: function(poruka){
                $( "#tekst" ).text( poruka );
                $( "#poruka" ).toggle();
          }
        });

        $('#brisanjeLogovaModal').modal('hide');
        });
        $('#btn-otkazi-logove').click(function(){
            $('#brisanjeLogovaModal').modal('hide');
        });
    });

    $(document).on('click','.zamene',function(){

        var rutaz = "{{ route('referenti.ciscenje') }}";

        $('#brisanjeZamene').modal('show');

        $('#btn-obrisi-zamene').click(function(){
            $.ajax({
            url: rutaz,
            type:"POST",
            data: {_token: "{!! csrf_token() !!}"},
            success: function(poruka){
                $( "#tekst" ).text( poruka );
                $( "#poruka" ).toggle();
          }
        });

        $('#brisanjeZamene').modal('hide');
        });
        $('#btn-otkazi-zamene').click(function(){
            $('#brisanjeZamene').modal('hide');
        });
    });

     $(document).on('click','.kretanja',function(){

        var rutak = "{{ route('kretanje.pospremanje') }}";

        $('#brisanjeKretanje').modal('show');

        $('#btn-obrisi-kretanje').click(function(){
            $.ajax({
            url: rutak,
            type:"POST",
            data: {_token: "{!! csrf_token() !!}"},
            success: function(poruka){
                $(window).scrollTop(0);
                $( "#tekst" ).text( poruka );
                $( "#poruka" ).toggle();
          }
        });

        $('#brisanjeKretanje').modal('hide');
        });
        $('#btn-otkazi-kretanje').click(function(){
            $('#brisanjeKretanje').modal('hide');
        });
    });

    $('#poruka').on('closed.bs.alert', function () {
        location.reload();
    });
});
</script>
@endsection