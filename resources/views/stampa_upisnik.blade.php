@extends('sabloni.app')

@section('naziv', 'Штампање уписника')

@section('naslov')
<div class="row">
    <div class="col-md-12">
<h1>
    Уписник "{{ $predmet->vrstaUpisnika->slovo }}"
</h1>
</div>
</div>
<hr>

<table class="table table-striped table-bordered table-responsive" style="table-layout: fixed;">
    <tbody>
        <tr>
            <th><strong>Број предмета:</strong></th>
            <th><strong>Датум пријема:</strong></th>
            <th><strong>Тужилац</strong></th>
            <th><strong>Туженик</strong></th>
            
        </tr>
        <tr>
            <td style="font-size:1.5em;"><strong>{{ $predmet->broj_predmeta }}</strong></td>
            <td>{{ date('d.m.Y', strtotime($predmet->datum_tuzbe)) }}</td>

            <td><ul class="list-unstyled">
                    @foreach ($predmet->tuzioci as $s1)
                    <li>{{ $s1->naziv }}</li>
                    @endforeach
                </ul></td>
            <td><ul class="list-unstyled">
                    @foreach ($predmet->tuzeni as $s2)
                    <li>{{ $s2->naziv }}</li>
                    @endforeach
                </ul></td>
        </tr>

            </tbody>
</table>

<hr>
<table class="table table-striped table-bordered table-responsive" style="table-layout: fixed;">
<tbody>
        <tr>
            <th><strong>Код кога суда се спор води и под којим пословним бројем:</strong></th>
            <th><strong>Врста предмета:</strong></th>
            <th><strong>Опис предмета:</strong></th>
        </tr>
        <tr>
            <td>{{ $predmet->sud->naziv }} са бројем: <span class="text-success"><strong>{{ $predmet->broj_predmeta_sud }}</strong></span></td>
            <td>{{ $predmet->vrstaPredmeta->naziv }}</td>
            <td>{{ $predmet->opis }}</td>
        </tr>

            </tbody>
</table>

<div class="row">
    <div class="col-md-6 col-md-offset-6 text-right">
        <button id="stampaj" class="btn btn-default ono" value="{{$predmet->id}}">
            <i class="fa fa-print fa-fw"></i> Штампај
        </button>
        </div>
    </div>
@endsection

@section('skripte')
<script>
    $(document).ready(function () {

        $('#stampaj').click(function() {
             var id = $(this).val();
             var ruta = "{{ route('predmeti.pregled', ':menjaj') }}";
             ruta = ruta.replace(':menjaj', id);
            window.print();
            document.location.href = ruta;
        });

    });
</script>


@endsection
