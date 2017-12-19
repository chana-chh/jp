@extends('sabloni.app')

@section('naziv', 'Извештаји')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header">Извештаји</h1>

<form action="{{ route('izvestaji.post') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label for="datum">Датум:</label>
                <input type="date" name="datum" id="datum" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="ime">Име и презиме:</label>
                <input type="text" name="ime" id="ime" class="form-control" value="Петар Петровић">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="tekst">Текст:</label>
                <textarea name="tekst" id="tekst" class="form-control" style="height: 30rem;">Lorem Ipsum је једноставно модел текста који се користи у штампарској и словослагачкој индустрији. Lorem ipsum је био стандард за модел текста још од 1500. године, када је непознати штампар узео кутију са словима и сложио их како би направио узорак књиге. Не само што је овај модел опстао пет векова, него је чак почео да се користи и у електронским медијима, непроменивши се. Популаризован је шездесетих година двадесетог века заједно са листовима летерсета који су садржали Lorem Ipsum пасусе, а данас са софтверским пакетом за прелом као што је Aldus PageMaker који је садржао Lorem Ipsum верзије.Насупрот веровању, Lorem Ipsum није насумично изабран и сложен текст. Његови корени потичу у делу класичне Латинске књижевности од 45. године пре нове ере, што га чини старим преко 2000 година. Richard McClintock, професор латинског на Hampden-Sydney колеџу у Вирџинији, је потражио дефиницију помало чудне речи "consectetur" из Lorem Ipsum пасуса и анализирајући делове речи у класичној књижевности отркио аутентичан извор. Lorem Ipsum долази из поглавља 1.10.32 и 1.10.33 књиге "de Finibus Bonorum et Malorum" (Екстреми Бога и Зла) коју је написао Cicerо 45. године пре нове ере. Књига говори о теорији етике, која је била врло популарна током Ренесансе. Прва реченица Lorem Ipsum модела "Lorem ipsum dolor sit amet..", долази из реченице у поглављу 1.10.32. Стандардни део Lorem Ipsum је од 1500. године је репродукован по жељи. Поглавља 1.10.32 и 1.10.33 књиге "de Finibus Bonorum et Malorum" коју је написао Cicerо су такође репродукована али у оригиналном формату заједно са енглеским преводом од H. Rackham из 1914. године.</textarea>
            </div>
        </div>
    </div>
    <input type="submit" name="submit" id="submit" value="Изради документ" class="btn btn-primary">
</form>
<p class="text-info" style="margin-top: 3rem;">
    * Документа се снимају на заједничком диску (P disk) у директоријуму dokumenta.
</p>
@endsection
