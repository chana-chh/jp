@extends('sabloni.app')

@section('naziv', 'Извештаји')

@section('meni')
@include('sabloni.inc.meni')
@endsection

@section('naslov')
<h1 class="page-header">Извештаји</h1>

<?php
$komplet = new \PhpOffice\PhpWord\PhpWord();
$resenje = $komplet->addSection();
$resenje->addText('latinica');
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($komplet, 'Word2007');
$objWriter->save('D:\\dokumenti\\tes.docx');
?>
@endsection
