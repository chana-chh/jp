@extends('sabloni.app')

@section('naziv', 'Скенирана документација')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header"><img class="slicica_animirana" alt="Скенирана документација"
                 src="{{url('/images/slike.png')}}" style="height:64px;">
            &emsp;Скенирана документација
        </h1>
@endsection

@section('sadrzaj')
@if($slike->count()>0)
@foreach($slike as $s)
<div class="col-md-3">
    <div class="img-thumbnail center-block" style="margin: 10px auto;">
        <img data-toggle="modal"
             data-target="#slikaModal"
             src="{{asset('images/skenirano/' . $s->src)}}"
             class="img-responsive"
             style="height: 200px; margin: 10px auto;">
        <button class="btn btn-danger btn-xs btn-block otvori-brisanje"
                style="width: 80%; margin: 5px auto;"
                {{-- data-toggle="modal" data-target="#brisanjeModal" --}}
                value="{{$s->id}}">
            <i class="fa fa-trash"></i>
        </button>
    </div>
</div>
@endforeach
@else
<h3 class="text-danger">За овај предмет нема скенираних докумената</h3>
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
                <h3>Да ли желите трајно да обришете скенирани докуменат? *</h3>
                <p class = "text-danger">* Ова акција је неповратна!</p>
            </div>
            <div class = "modal-footer">
                <button id="btn-brisanje-obrisi" class="btn btn-warning">
                    <i class="fa fa-trash"></i> Обриши
                </button>
                <button id="btn-brisanje-otkazi" class="btn btn-danger">
                    <i class = "fa fa-ban"></i> Откажи
                </button>
            </div>
        </div>
    </div>
</div>
    {{-- Kraj Modala za dijalog brisanje--}}
@endsection

@section('traka')
<h3 >Додавање новог скенираног документа</h3>
{{--  POCETAK SLIKA  --}}
<div class="row" style="margin-bottom: 2rem;">
                <div class="col-md-12 text-right">
                    <form action="{{route('predmeti.slike.post', $predmet->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                    <div class="input-group image-preview">
                        <input type="text" class="form-control image-preview-filename" disabled="disabled">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger image-preview-clear" style="display:none;">
                                <span class="glyphicon glyphicon-remove"></span> Поништи
                            </button>
                            <div class="btn btn-warning image-preview-input">
                                <span>
                                    <i class="fa fa-upload" aria-hidden="true"></i>
                                </span>
                                <span class="image-preview-input-title">Одабери</span>
                                <input type="file" accept="image/png, image/jpeg, image/gif" name="slika" id="slika" required/>
                            </div>
                            <button type="submit" class="btn btn-success">
            <i class="fa fa-floppy-o"></i> Сачувај
        </button>
                        </span>
                    </div>
                            
    </form>
                </div>
            </div>

<div id="slikaModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img id="skan" class="img-responsive center-block" src="" style="width: 100%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Затвори</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('skripte')
<script>
$( document ).ready(function() {

    // Petljanje sa slikom ou jeee

    $(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');

    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
        }, 
         function () {
           $('.image-preview').popover('hide');
        }
    );    
});

$(function() {

    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");

    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Преглед</strong>"+$(closebtn)[0].outerHTML,
        content: "Фотографија није одабрана",
        placement:'bottom'
    });

    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Одабери скенирани документ"); 
    }); 

    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:180,
            height:200
        });      
        var file = this.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Izmeni");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);            
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});
        
        // KRAJ petljanje sa slikom ou jeee

    $('#slikaModal').on('show.bs.modal', function (e) {
        var image = $(e.relatedTarget).attr('src');
        $('#skan').attr('src', image);
    });

    $(document).on('click', '.otvori-brisanje', function () {
             var id_brisanje = $(this).val();
             console.log(id_brisanje);
             var ruta = "{{ route('predmeti.slike.brisanje') }}";
             console.log(ruta);
             $('#brisanjeModal').modal('show');
             $('#btn-brisanje-obrisi').click(function () {
                 $.ajax({
                     url: ruta,
                     type: "POST",
                     data: {
                         "id": id_brisanje,
                         "_token": "{!! csrf_token() !!}"
                     },
                     success: function () {
                         location.reload();
                     }
                 });
                 $('#brisanjeModal').modal('hide');
             });
             $('#btn-brisanje-otkazi').click(function () {
                 $('#brisanjeModal').modal('hide');
             });
        });
});
</script>
@endsection