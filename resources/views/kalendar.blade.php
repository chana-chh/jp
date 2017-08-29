@extends('sabloni.app')

@section('naziv', 'Календар')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('stilovi')
<link href="{{ asset('/css/fullcalendar.css') }}" rel="stylesheet">
@endsection

@section('naslov')
    <h1 class="page-header">Календарски преглед рочишта</h1>
    <div class="col-md-12" id='calendar'></div>
@endsection

@section('skripte')
<script src="{{ asset('/js/moment.min.js') }}"></script>
<script src="{{ asset('/js/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/js/sr-cyrl.js') }}"></script>
<script>
    $(document).ready(function() {
        var naslovi = {!! $naslovie !!};
        var datumi  = {!! $datumie  !!};
        var detalji  = {!! $detaljie  !!};
        var duzina = naslovi.length;
        var dogadjaji = [];

        for(var i = 0;  i < duzina; i++) {
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
            header: {
                left: 'prev,next today',
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
            height: 700,
            events: dogadjaji,
            eventRender: function (event, element, view) {
                element.find('.fc-title').append('<hr style="margin: 5px 0;"><span style="font-size: 12px">' + event.description + '</span></div>');
            },
            dayNames: ['понедељак', 'уторак', 'среда', 'четвртак', 'петак', 'субота', 'недеља'],
            dayNamesShort: ['понедељак', 'уторак', 'среда', 'четвртак', 'петак', 'субота', 'недеља'],
            monthNames: ['јануар', 'фебруар', 'март', 'април', 'мај', 'јун', 'јул', 'август', 'септембар', 'октобар', 'новембар', 'децембар'],
            monthNamesShort: ['јануар', 'фебруар', 'март', 'април', 'мај', 'јун', 'јул', 'август', 'септембар', 'октобар', 'новембар', 'децембар']
        })
});
</script>
@endsection