@extends('sabloni.app')

@section('naziv', 'Ток новца')

@section('meni')
    @include('sabloni.inc.meni')
@endsection
@section('naslov')
    <h1 class="page-header">
        <span><img alt="рочиште" src="{{url('/images/novac.png')}}" style="height:64px"></span>&emsp;
        Ток новца
    </h1>
{{-- Sekcija sa krugovima - POCETAK --}}
<div class="row">
<div class="col-md-10 col-md-offset-1 boxic">

<div class="row">
<div class="col-md-6">
<h3>Сума вредности спорова:</h3>
</div>
<div class="col-md-6">
<h3>Сума износа трошкова:</h3>
</div>
</div>
<hr class="ceo">
<div class="row">
<div class="col-md-3">
<h3>Град потражује:</h3>
<p class="tankoza krug">{{number_format($vrednost_spora_potrazuje_suma, 2)}}</p>
</div>
<div class="col-md-3">
<h3>Град дугује:</h3>
<p class="tankoza krug">{{number_format($vrednost_spora_duguje_suma, 2)}}</p>
</div>
<div class="col-md-3">
<h3>Град потражује:</h3>
<p class="tankoza krug">{{number_format($iznos_troskova_potrazuje_suma, 2)}}</p>
</div>
<div class="col-md-3">
<h3>Град дугује:</h3>
<p class="tankoza krug">{{number_format($iznos_troskova_duguje_suma, 2)}}</p>
</div>
</div>

<div class="row">
<div class="col-md-6">
<h3 class=" tankoza {{ $vs >= 0 ? ' tankoza' : ' tankoza_danger' }}" >Салдо: {{ number_format($vs, 2, ',', '.') }}</h3>
</div>
<div class="col-md-6">
<h3 class="{{ $it >= 0 ? ' tankoza' : ' tankoza_danger' }}" >Салдо: {{ number_format($it, 2, ',', '.') }}</h3>
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
<hr>
</div class="row">
<div class="col-md-10 col-md-offset-1">
    <div class="panel-group" id="accordion"> {{-- Pocetak PANEL GRUPE --}}
        <div class="panel panel-default"> {{-- Pocetak PANELA --}}
            <div class="panel-heading"> {{-- Pocetak naslova panela --}}
                <a class="btn btn-primary" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="fa fa-search"></i> Напредна претрага
                </a>
                <a href="{{ route('tok') }}" class="btn btn-info">
                    <i class="fa fa-ban"></i> Поништи филтер
                </a>
            </div> {{-- Kraj naslova panela --}}
            <div id="collapseOne" class="panel-collapse collapse"> {{-- Pocetak XXX panela --}}
                <div class="panel-body"> {{-- Pocetak tela panela --}}
                    <form id="pretraga" action="{{ route('tok.pretraga') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="vrsta_predemta_id">Врста предмета</label>
                                <select
                                    name="vrsta_predemta_id" id="vrsta_predemta_id"
                                    class="form-control select_vp" data-placeholder="Врста предмета">
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
                                    class="form-control select_vu" data-placeholder="Врста уписника">
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
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="text-warning">Напомена</label>
                                <p class="text-warning">
                                    Ако се унесе само први датум претрага ће се вршити за предмете са тим датумом. Ако се унесу оба датума претрага ће се вршити за предмете између та два датума.
                                </p>
                            </div>
                        </div>
                    </form>
                </div> {{-- Kraj tela panela --}}
                <div class="panel-footer text-right">
                    <button id="dugme_pretrazi" class="btn btn-success"><i class="fa fa-search"></i> Претражи</button>
                </div>
            </div> {{-- Kraj XXX panela --}}
        </div> {{-- Kraj PANELA --}}
    </div> {{-- Kraj PANEL GRUPE --}}
</div>
</div>
@endsection

@section('skripte')
<script>
    $( document ).ready(function() {

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