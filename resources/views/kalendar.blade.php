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
            weekends: false,
            height: 700,
            events: dogadjaji,
            eventRender: function (event, element, view) {
            element.find('.fc-title').append('<div class="hr-line-solid-no-margin"></div><hr style="margin: 2px"><span style="font-size: 10px">'+event.description+'</span></div>');
            },
        })
});
</script>
@endsection