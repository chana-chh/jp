@extends('sabloni.app')

@section('naziv', 'Календар')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('stilovi')
<link href="{{ asset('/css/fullcalendar.css') }}" rel="stylesheet">
@endsection

@section('naslov')
    <h1 class="page-header">
    <span><img alt="рочиште" src="{{url('/images/kalendar.png')}}" style="height:64px"></span>&emsp;
    Календарски преглед рочишта</h1>
    <div class="row boxic">
    <div class="col-md-12 ceo" id='calendar'></div>
    </div>
{{-- Sekcija sa dugicima - POCETAK --}}
<div class="row dugmici">
<div class="col-md-10 col-md-offset-1">

<div class="row">
<div class="col-md-6" style="border-right: 2px dashed #18BC9C" >
<a class="btn btn-primary btn-block" href="{{ route('rocista.dodavanje.get') }}"><i class="fa fa-plus-circle fa-fw"></i>&emsp;Додај рочиште
</a>
</div>
<div class="col-md-6">
<a class="btn btn-primary btn-block" href="{{ route('rocista') }}"><i class="fa fa-table fa-fw"></i>&emsp;Табеларни приказ рочишта</a>
</div>
</div>

</div>
</div>
{{-- Sekcija sa dugmicima - KRAJ --}}
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
            height: 630,
            events: dogadjaji,
            eventRender: function (event, element, view) {
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