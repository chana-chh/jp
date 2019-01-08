@extends('sabloni.app')

@section('naziv', 'Календар рочишта/рокова')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('stilovi')
<link href="{{ asset('/css/fullcalendar.css') }}" rel="stylesheet">
<link href="{{ asset('/css/fullcalendar.print.css') }}" rel="stylesheet" media="print">
@endsection

@section('naslov')
<div class="row ne_stampaj">
    <div class="col-md-6">
        <h1>
            <img class="slicica_animirana" alt="календар рочишта" src="{{url('/images/kalendar.png')}}" style="height:64px">
             Календарски преглед рочишта/рокова
        </h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 40px;">
        <button id="pretragaDugme" class="btn btn-default btn-block ono">
            <i class="fa fa-filter fa-fw"></i> Филтер
        </button>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 40px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('rocista.dodavanje.get') }}"><i class="fa fa-plus-circle fa-fw"></i>&emsp;Додај рочиште/рок
        </a>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 40px;">
        <a class="btn btn-success btn-block ono" href="{{ route('rocista') }}"><i class="fa fa-table fa-fw"></i>&emsp;Табеларни приказ</a>
    </div>
</div>
<hr>
<div id="pretraga_div" class="well" style="display: none;">
    <form id="pretraga" action="{{ route('rocista.kalendar.filter.post') }}" method="POST">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-md-3">
                <label for="tip_id">Тип рочишта</label>
                <select
                    name="tip_id" id="tip_id"
                    class="chosen-select form-control" data-placeholder="Тип рочишта">
                    <option value=""></option>
                    @foreach($tipovi as $tip)
                    <option value="{{ $tip->id }}">
                    <strong>{{ $tip->naziv }}</strong>
                    </option>
                    @endforeach
                </select>
            </div>
                        <div class="form-group col-md-3">
                <label for="referent_id">Референт</label>
                <select
                    name="referent_id" id="referent_id"
                    class="chosen-select form-control" data-placeholder="Референт">
                    <option value=""></option>
                    @foreach($referenti as $referent)
                    <option value="{{ $referent->id }}">
                        {{ $referent->imePrezime() }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-6 text-right ceo_dva">
                <div class="col-md-6 snimi">
                    <button type="submit" id="dugme_pretrazi" class="btn btn-success btn-block"><i class="fa fa-filter"></i>&emsp;Примени филтер</button>
                </div>
                                <div class="col-md-6">
                    <a class="btn btn-info btn-block" href="{{ route('rocista.kalendar') }}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="row">
    <div class="col-md-12" id='calendar'></div>
</div>
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/js/sr-cyrl.js') }}"></script>
<script>
$(document).ready(function() {

        jQuery(window).on('resize', resizeChosen);

        $('.chosen-select').chosen({
            allow_single_deselect: true,
            search_contains: true
        });

        function resizeChosen() {
            $(".chosen-container").each(function () {
                $(this).attr('style', 'width: 100%');
            });
        }

    $('#datum_1').on('change', function () {
            if (this.value !== '') {
                $('#datum_2').prop('readonly', false);
            } else {
                $('#datum_2').prop('readonly', true).val('');
            }
        });
    
    $('#pretragaDugme').click(function () {
        $('#pretraga_div').toggle();
        resizeChosen();
    });

    $('#dugme_pretrazi').click(function () {
        $('#pretraga').submit();
    });

var naslovi = {!! $naslovie !!};
var datumi = {!! $datumie  !!};
var detalji = {!! $detaljie  !!};
var duzina = naslovi.length;
var dogadjaji = [];
for (var i = 0; i < duzina; i++) {
var naslov = naslovi[i];
var datum = datumi[i];
var detalj = detalji[i];
var dodajDogadjaj = {};
dodajDogadjaj = {
title: naslov,
        start: datum,
        description: detalj
}
dogadjaji.push(dodajDogadjaj);
}

$('#calendar').fullCalendar({
    customButtons: {
        myCustomButton: {
            text: 'Штампај',
            click: function() {
                window.print();
            }
        }
    },
header: {
left: 'prev,next today myCustomButton',
        center: 'title',
        right: 'month,basicWeek,basicDay'
},
        views: {
        month: {
        columnFormat:'dddd'
        }
        },
        defaultView: 'basicWeek',
        weekends: false,
        height: 630,
        events: dogadjaji,
        eventBackgroundColor: "#FFFFFF",
        eventBorderColor: "#2C3E50",
        eventTextColor: "#1A242F",
        eventRender: function (event, element, view) {
        var title = element.find( '.fc-title' );
        title.html( title.text() );
        title.attr('style', 'font-size: 1.2em !important');
        $(element).css("margin-top", "5px");
        element.find('.fc-title').append('<hr style="margin: 5px 0;"><span style="font-size: 12px">' + event.description + '</span></div>');
        },
        dayNames: ['недеља', 'понедељак', 'уторак', 'среда', 'четвртак', 'петак', 'субота'],
        dayNamesShort: ['недеља', 'понедељак', 'уторак', 'среда', 'четвртак', 'петак', 'субота'],
        monthNames: ['јануар', 'фебруар', 'март', 'април', 'мај', 'јун', 'јул', 'август', 'септембар', 'октобар', 'новембар', 'децембар'],
        monthNamesShort: ['јануар', 'фебруар', 'март', 'април', 'мај', 'јун', 'јул', 'август', 'септембар', 'октобар', 'новембар', 'децембар']
})
        });
</script>
@endsection
