@extends('sabloni.app')

@section('naziv', 'Календар рочишта/рокова')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('stilovi')
<link href="{{ asset('/css/fullcalendar.css') }}" rel="stylesheet">
@endsection

@section('naslov')
<div class="row ne_stampaj">
    <div class="col-md-10">
        <h1>
            <img class="slicica_animirana" alt="календар рочишта" src="{{url('/images/kalendar.png')}}" style="height:64px">
             Календарски преглед <small class="text-danger"><em>(филтриран)</em></small>
        </h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 50px;">
        <a class="btn btn-primary btn-block ono" href="{{ route('rocista.kalendar') }}">
            <i class="fa fa-plus-circle fa-fw"></i> Уклони филтер
        </a>
    </div>
</div>
<hr>
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
        eventRender: function (event, element, view) {
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
