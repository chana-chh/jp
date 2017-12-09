@extends('sabloni.app')

@section('naziv', 'Скенирана документација')

@section('meni')
    @include('sabloni.inc.meni')
@endsection

@section('naslov')
    <h1 class="page-header"><img class="slicica_animirana" alt="Скенирана документација"
                 src="{{url('/images/sud.jpg')}}" style="height:64px;">
            &emsp;Скенирана документација
        </h1>
@endsection

@section('sadrzaj')
  Слике

        {{-- Modal za dijalog brisanje--}}
    <div class="modal fade" id="brisanjeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="brisanjeModalLabel">Упозорење!</h4>
            </div>
            <div class="modal-body">
                <h4 class="text-primary">Да ли желите трајно да обришете ставку</strong></h4>
                <p ><strong>Ова акција је неповратна!</strong></p>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-success" id="btn-obrisi">Обриши</button>
            <button type="button" class="btn btn-danger" id="btn-otkazi">Откажи</button>
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
                <div class="col-md-12 text-center">
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
                                <span class="image-preview-input-title">Одабери скенирани документ</span>
                                <input type="file" accept="image/png, image/jpeg, image/gif" name="slika" id="slika" />
                            </div>
                        </span>
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
        title: "<strong>Pregled</strong>"+$(closebtn)[0].outerHTML,
        content: "Fotografija nije odabrana",
        placement:'bottom'
    });

    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Odaberi fotografiju zaposlenog"); 
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

    $(document).on('click','.otvori_modal',function(){

        var id = $(this).val();
        
        var ruta = "{{ route('sudovi.brisanje') }}";


        $('#brisanjeModal').modal('show');

        $('#btn-obrisi').click(function(){
            $.ajax({
            url: ruta,
            type:"POST", 
            data: {"id":id, _token: "{!! csrf_token() !!}"}, 
            success: function(){
            location.reload(); 
          }
        });

        $('#brisanjeModal').modal('hide');
        });
        $('#btn-otkazi').click(function(){
            $('#brisanjeModal').modal('hide');
        });
    });
});
</script>
<script src="{{ asset('/js/parsley.js') }}"></script>
<script src="{{ asset('/js/parsley_sr.js') }}"></script>
@endsection