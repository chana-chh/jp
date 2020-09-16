@extends('sabloni.app')

@section('naziv', 'Рокови/рочишта - избор')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header" style="text-align: center">РОКОВИ / РОЧИШТА - избор</h1>
<div class="row">
    <div class="col-md-5">
        <h1>
        <img class="img-responsive center-block" alt="Рокови" style="height:256px;"
        src="{{url('/images/rok.png')}}">
        </h1>
        <hr>
        <h2 class="text-center">
        <a href="{{ route('rokovi.kalendar') }}">Рокови</a>
        </h2>
    </div>
    <div class="col-md-2">
    </div>
    <div class="col-md-5">
        <h1>
        <img  class="img-responsive center-block" alt="Рочишта" style="height:256px; text-align: center"
        src="{{url('/images/rociste.png')}}">
        </h1>
        <hr>
        <h2 class="text-center">
        <a href="{{ route('rocista.kalendar') }}">Рочишта</a>
        </h2>
    </div>
</div>
@if (Gate::allows('admin'))
<div class="well" style="margin-top: 50px">
    <div class="row">
    <div class="col-md-10">
        <h3>
            <img class="slicica_animirana" alt="календар рочишта" src="{{url('/images/kalendar.png')}}" style="height:64px">
             Брисање свих рокова и рочишта старијих од годину дана !!!
        </h3>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 40px;">
        <button id="pospremanjeDugme" class="btn btn-danger">
            <i class="fa fa-trash fa-fw"></i> Бриши
        </button>
    </div>
</div>
</div>
@endif

{{--  pocetak modal_arhiviranje  --}}
<div class="modal fade" id="pospremanjeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title text-warning">Брисање застарелих рокова и рочишта</h3>
            </div>
            <div class="modal-body">
                <h3>Да ли желите да обришете застареле рокове/рочишта?</h3>
                <p class="text-danger">
                    * Опрез ова акција је неповратна !!!
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="dugmeModalPospremi">
                    <i class="fa fa-trash"></i> Бриши
                </button>
                <button type="button" class="btn btn-primary" id="dugmeModalOtkazi">
                    <i class="fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
{{--  kraj modal_arhiviranje  --}}
@endsection
@section('skripte')
<script>

        var pospremanje_ruta = "{{ route('rocista.pospremanje') }}";
    // Modal arhiviranje
        $(document).on('click', '#pospremanjeDugme', function () {

            $('#pospremanjeModal').modal('show');
            $('#dugmeModalPospremi').on('click', function () {

                $.ajax({
                    url: pospremanje_ruta,
                    type: "POST",
                    data: {
                        "tip":1,
                        _token: "{!! csrf_token() !!}"
                    },
                    success: function () {
                        location.reload();
                    }
                });
                $('#pospremanjeModal').modal('hide');
            });
            $('#dugmeModalOtkazi').on('click', function () {
                $('#pospremanjeModal').modal('hide');
            });
        });
</script>
@endsection