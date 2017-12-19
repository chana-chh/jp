@extends('sabloni.app')

@section('naziv', 'Ток новца')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    
<div class="row">
    <div class="col-md-10">
       <h1>
        <span><img class="slicica_animirana" alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца
    </h1>
    </div>
    <div class="col-md-2 text-right" style="padding-top: 40px;">
        <button id="pretragaDugme" class="btn btn-success btn-block ono">
            <i class="fa fa-filter fa-fw"></i> Napredni filter
        </button>
    </div>
</div>
<hr>
<div id="pretraga_div" class="well" style="display: none;">
     <form id="pretraga" action="{{ route('tok.pretraga') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="vrsta_predemta_id">Врста предмета</label>
                                <select
                                    name="vrsta_predemta_id" id="vrsta_predemta_id"
                                    class="form-control select_vp chosen-select" data-placeholder="Врста предмета">
                                        <option value=""></option>
                                        @foreach($vrste as $vrsta)
                                        <option value="{{ $vrsta->id }}">
                                            {{ $vrsta->naziv }}
                                        </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="vrsta_upisnika_id">Врста уписника</label>
                                <select
                                    name="vrsta_upisnika_id" id="vrsta_upisnika_id"
                                    class="form-control select_vu chosen-select" data-placeholder="Врста уписника">
                                    <option value=""></option>
                                    @foreach($upisnici as $upisnik)
                                    <option value="{{ $upisnik->id }}">
                                        <strong>{{ $upisnik->naziv }}</strong>
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="stranka_1">Тужилац</label>
                                <input type="text" maxlen="255"
                                    name="stranka_1" id="stranka_1"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="stranka_2">Тужени</label>
                                <input type="text" maxlen="255"
                                    name="stranka_2" id="stranka_2"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <h4 class="leva">Вредности спорова потражује:</h4>
                            </div>
                            <div class="col-md-4">
                                <select
                                    name="operator_vsp" id="operator_vsp"
                                    class="form-control">
                                        <option value="" disabled selected>Одаберите критеријум</option>
                                        <option value=">=">Је већа или једнака вредности</option>
                                        <option value="<=">Је мања или једнака вредности</option>
                                        <option value="=">Је једнака вредности</option>
                                        <option value=">">Је већа од вредности</option>
                                        <option value="<">Је мања од вредности</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" min="0" step="1.00" name="vrednost_vsp" id="vrednost_vsp" class="form-control" placeholder="Унесите износ">    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <h4 class="leva">Вредности спорова дугује:</h4>
                            </div>
                            <div class="col-md-4">
                                <select
                                    name="operator_vsd" id="operator_vsd"
                                    class="form-control">
                                        <option value="" disabled selected>Одаберите критеријум</option>
                                        <option value=">=">Је већа или једнака вредности</option>
                                        <option value="<=">Је мања или једнака вредности</option>
                                        <option value="=">Је једнака вредности</option>
                                        <option value=">">Је већа од вредности</option>
                                        <option value="<">Је мања од вредности</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" min="0" step="1.00" name="vrednost_vsd" id="vrednost_vsd" class="form-control" placeholder="Унесите износ">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <h4 class="leva">Износа трошкова потражује:</h4>
                            </div>
                            <div class="col-md-4">
                                <select
                                    name="operator_itp" id="operator_itp"
                                    class="form-control">
                                        <option value="" disabled selected>Одаберите критеријум</option>
                                        <option value=">=">Је већа или једнака вредности</option>
                                        <option value="<=">Је мања или једнака вредности</option>
                                        <option value="=">Је једнака вредности</option>
                                        <option value=">">Је већа од вредности</option>
                                        <option value="<">Је мања од вредности</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" min="0" step="1.00" name="vrednost_itp" id="vrednost_itp" class="form-control" placeholder="Унесите износ">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-md-offset-1">
                                <h4>Износа трошкова дугује:</h4>
                            </div>
                            <div class="col-md-4">
                                <select
                                    name="operator_itd" id="operator_itd"
                                    class="form-control">
                                        <option value="" disabled selected>Одаберите критеријум</option>
                                        <option value=">=">Је већа или једнака вредности</option>
                                        <option value="<=">Је мања или једнака вредности</option>
                                        <option value="=">Је једнака вредности</option>
                                        <option value=">">Је већа од вредности</option>
                                        <option value="<">Је мања од вредности</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" min="0" step="1.00" name="vrednost_itd" id="vrednost_itd" class="form-control" placeholder="Унесите износ">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="opis">Датум 1</label>
                                <input type="date"
                                    name="datum_1" id="datum_1"
                                    class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="opis">Датум 2</label>
                                <input type="date"
                                    name="datum_2" id="datum_2"
                                    class="form-control" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="text-warning">Напомена</label>
                                <p class="text-warning">
                                    Ако се унесе само први датум претрага ће се вршити за предмете са тим датумом. Ако се унесу оба датума претрага ће се вршити за предмете између та два датума.
                                </p>
                            </div>
                        </div>
                        <hr>
        <div class="row dugmici">
        <div class="col-md-6 col-md-offset-6">
        <div class="form-group text-right ceo_dva">
        <div class="col-md-6 snimi">
            <button type="button" id="dugme_pretrazi" class="btn btn-success btn-block"><i class="fa fa-filter"></i>&emsp;Филтрирај</button>
        </div>
        <div class="col-md-6">
            <a class="btn btn-danger btn-block" href="{{ route('tok') }}"><i class="fa fa-ban"></i>&emsp;Откажи</a>
        </div>
        </div>
        </div>
        </div>
                    </form>
</div>
{{-- Sekcija sa krugovima - POCETAK --}}
<div class="row">
<div class="col-md-10 col-md-offset-1 boxic">

<div class="row">
<div class="col-md-6">

	<div class="row ceo_dva">
	<div class="col-md-12">
    <h3>Сума вредности спорова:</h3>
    <hr class="ceo">
</div>
</div>

<div class="row">
<div class="col-md-6">
<h3>Град потражује:</h3>
<p class="tankoza krug">{{number_format($vrednost_spora_potrazuje_suma, 2)}}</p>
</div>
<div class="col-md-6">
<h3>Град дугује:</h3>
<p class="tankoza krug">{{number_format($vrednost_spora_duguje_suma, 2)}}</p>
</div>

<div class="row ceo_dva">
<div class="col-md-12">
<hr class="ceo">
<h3 class="{{ $vs >= 0 ? ' tankoza' : ' tankoza_danger' }}" >Салдо: {{ number_format($vs, 2, ',', '.') }}</h3>
</div>
</div>

</div>
</div>

<div class="col-md-6">
	<div class="row ceo_dva">
		<div class="col-md-12">
    <h3>Сума износа трошкова:</h3>
    <hr class="ceo">
</div>
</div>

    <div class="row">
<div class="col-md-6">
<h3>Град потражује:</h3>
<p class="tankoza krug">{{number_format($iznos_troskova_potrazuje_suma, 2)}}</p>
</div>
<div class="col-md-6">
<h3>Град дугује:</h3>
<p class="tankoza krug">{{number_format($iznos_troskova_duguje_suma, 2)}}</p>
</div>

<div class="row ceo_dva">
	<div class="col-md-12">
		<hr class="ceo">
<h3 class="{{ $it >= 0 ? ' tankoza' : ' tankoza_danger' }}" >Салдо: {{ number_format($it, 2, ',', '.') }}</h3>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
{{-- Sekcija sa krugovima - KRAJ --}}

{{-- Sekcija sa dugicima - POCETAK --}}
<div class="row dugmici ceo_dva">
<div class="col-md-10 col-md-offset-1">

<div class="row">
<div class="col-md-6 snimi">
<h3>Табеларни приказ:</h3>
<div class="row">
<div class="col-md-6">
<a class="btn btn-primary btn-block" href="{{ route('tok.grupa_predmet') }}">Груписано по предметима</a>
</div>
<div class="col-md-6">
<a class="btn btn-primary btn-block gornja" href="{{ route('tok.grupa_vrste_predmeta') }}">Груписано по врсти предмета</a>
</div>
</div>
</div>
<div class="col-md-6">
<h3>Графички приказ:</h3>
<div class="row">
<div class="col-md-6">
<a class="btn btn-primary btn-block" href="{{ route('tok.tekuci_mesec') }}">Текући месец</a>
</div>
<div class="col-md-6">
<a class="btn btn-primary btn-block gornja" href="{{ route('tok.tekuca_godina') }}">Текућа година</a>
</div>
</div>
</div>
</div>

</div>
</div>
{{-- Sekcija sa dugmicima - KRAJ --}}

@endsection

@section('skripte')
<script>
    $( document ).ready(function() {

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

        $('#dugme_pretrazi').click(function() {
            
           var sviInputi = $( '#pretraga input, .select_vp, .select_vu' );
           var prazni = 0;
           
           $(sviInputi).each(function(){
           if($(this).val() === "") prazni+=1;
        	});

           console.log("Svi inputi: " + sviInputi.length + " Prazni:" + prazni);

           if((sviInputi.length -1) -  prazni > 0){
           	$('#pretraga').submit();
        	}
        	else {
           	alert("Није одабран ниједан критеријум за претрагу!");
        	}
            
        });
            
    });
</script>
@endsection